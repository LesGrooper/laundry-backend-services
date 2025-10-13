<?php

namespace App\Http\Controllers\API\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * GET /api/invoices
     * Menampilkan semua invoice
     */
    public function index()
    {
        $invoices = DB::table('invoice')
            ->leftJoin('users', 'users.id', '=', 'invoice.invoice_generated_by')
            ->leftJoin('customers', 'customers.id', '=', 'invoice.invoice_owner_id')
            ->select(
                'invoice.*',
                'users.name as generated_by',
                'customers.customers_name as customer_name',
                'customers.customers_phone_number as customer_phone'
            )
            ->orderBy('invoice.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar invoice berhasil diambil.',
            'data' => $invoices
        ]);
    }

    /**
     * POST /api/invoices
     * Membuat invoice baru
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'invoice_description' => 'nullable|string|max:255',
            'invoice_status' => 'required|string|max:255',
            'invoice_generated_by' => 'required|integer',
            'invoice_owner_id' => 'required|integer',
            'service_products_id' => 'required|integer',
        ]);

        $service = DB::table('service_products')->where('id', $request->service_products_id)->first();

        $durationDays = 3; // default reguler
        if (strtolower($service->service_products_category) === 'kilat') {
            $durationDays = 2;
        }

        $invoice_deadline = Carbon::now()->addDays($durationDays);

        if(isset($request->from)) {
            $invoice = Invoice::create([
                'invoice_description' => $request->invoice_description,
                'invoice_status' => $request->invoice_status,
                'invoice_generated_by' => $request->invoice_generated_by,
                'invoice_owner_id' => $request->invoice_owner_id,
                'invoice_deadline' => $invoice_deadline,
                'service_products_id' => $request->service_products_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        } else {
            $invoice = Invoice::create([
                'invoice_image' => $request->invoice_image,
                'invoice_description' => $request->invoice_description,
                'invoice_status' => $request->invoice_status,
                'invoice_generated_by' => $request->invoice_generated_by,
                'invoice_owner_id' => $request->invoice_owner_id,
                'invoice_deadline' => $invoice_deadline,
                'service_products_id' => $request->service_products_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil dibuat.',
            'data' => $invoice
        ], 201);
    }

    /**
     * GET /api/invoices/{id}
     * Menampilkan detail invoice
     */
    public function show($id)
    {
        $invoice = DB::table('invoice')
            ->leftJoin('users', 'users.id', '=', 'invoice.invoice_generated_by')
            ->leftJoin('customers', 'customers.id', '=', 'invoice.invoice_owner_id')
            ->select(
                'invoice.*',
                'users.name as generated_by',
                'customers.customers_name as customer_name',
                'customers.customers_address',
                'customers.customers_phone_number'
            )
            ->where('invoice.id', $id)
            ->first();

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $invoice
        ]);
    }

    /**
     * PUT /api/invoices/{id}
     * Mengupdate status atau informasi invoice
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice tidak ditemukan.'
            ], 404);
        }

        $this->validate($request, [
            'invoice_description' => 'nullable|string|max:255',
            'invoice_status' => 'nullable|string|max:255',
            'invoice_generated_by' => 'nullable|integer',
            'invoice_owner_id' => 'nullable|integer',
            'service_products_id' => 'required|integer',
            'updated_at' => now()
        ]);

        $invoice->update($request->only([
            'invoice_description',
            'invoice_status',
            'invoice_generated_by',
            'invoice_owner_id',
            'service_products_id',
            'updated_at'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil diperbarui.',
            'data' => $invoice
        ]);
    }

    /**
     * DELETE /api/invoices/{id}
     * Menghapus invoice
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice tidak ditemukan.'
            ], 404);
        }

        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice berhasil dihapus.'
        ]);
    }

    /**
     * GET /api/invoices/report
     * Menampilkan laporan invoice (filter by status / tanggal)
     */
    public function report(Request $request)
    {
        $query = DB::table('invoice')
            ->leftJoin('users', 'users.id', '=', 'invoice.invoice_generated_by')
            ->leftJoin('customers', 'customers.id', '=', 'invoice.invoice_owner_id')
            ->select(
                'invoice.*',
                'users.name as generated_by',
                'customers.customers_name as customer_name'
            );

        if ($request->has('status')) {
            $query->where('invoice.invoice_status', $request->status);
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('invoice.created_at', [$request->from_date, $request->to_date]);
        }

        $report = $query->orderBy('invoice.id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Laporan invoice berhasil diambil.',
            'data' => $report
        ]);
    }
}
