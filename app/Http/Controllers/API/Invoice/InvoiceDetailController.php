<?php

namespace App\Http\Controllers\API\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InvoiceDetail;

class InvoiceDetailController extends Controller
{
    /**
     * GET /api/invoice-details
     * Menampilkan semua detail invoice
     */
    public function index()
    {
        $details = DB::table('invoice_details')
            ->leftJoin('invoice', 'invoice.id', '=', 'invoice_details.invoice_id')
            ->leftJoin('service_products', 'service_products.id', '=', 'invoice_details.service_products_id')
            ->select(
                'invoice_details.*',
                'service_products.service_products_name',
                'service_products.service_products_category',
                'invoice.invoice_status'
            )
            ->orderBy('invoice_details.id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar detail invoice berhasil diambil.',
            'data' => $details
        ]);
    }

    /**
     * POST /api/invoice-details
     * Menambahkan detail baru ke invoice
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'invoice_id' => 'required|integer',
            'service_products_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $subtotal = $request->quantity * $request->price;

        $detail = InvoiceDetail::create([
            'invoice_id' => $request->invoice_id,
            'service_products_id' => $request->service_products_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'subtotal' => $subtotal
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail invoice berhasil ditambahkan.',
            'data' => $detail
        ], 201);
    }

    /**
     * GET /api/invoice-details/{id}
     * Menampilkan detail invoice berdasarkan ID
     */
    public function show($id)
    {
        $detail = DB::table('invoice_details')
            ->leftJoin('service_products', 'service_products.id', '=', 'invoice_details.service_products_id')
            ->select(
                'invoice_details.*',
                'service_products.service_products_name',
                'service_products.service_products_category'
            )
            ->where('invoice_details.id', $id)
            ->first();

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail invoice tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    /**
     * PUT /api/invoice-details/{id}
     * Mengupdate data detail invoice
     */
    public function update(Request $request, $id)
    {
        $detail = InvoiceDetail::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail invoice tidak ditemukan.'
            ], 404);
        }

        $this->validate($request, [
            'quantity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0'
        ]);

        $data = $request->only(['quantity', 'price']);
        if (isset($data['quantity']) || isset($data['price'])) {
            $quantity = $data['quantity'] ?? $detail->quantity;
            $price = $data['price'] ?? $detail->price;
            $data['subtotal'] = $quantity * $price;
        }

        $detail->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Detail invoice berhasil diperbarui.',
            'data' => $detail
        ]);
    }

    /**
     * DELETE /api/invoice-details/{id}
     * Menghapus detail invoice
     */
    public function destroy($id)
    {
        $detail = InvoiceDetail::find($id);

        if (!$detail) {
            return response()->json([
                'success' => false,
                'message' => 'Detail invoice tidak ditemukan.'
            ], 404);
        }

        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Detail invoice berhasil dihapus.'
        ]);
    }

    /**
     * GET /api/invoice-details/by-invoice/{invoice_id}
     * Menampilkan semua item detail dari satu invoice
     */
    public function getByInvoice($invoice_id)
    {
        $details = DB::table('invoice_details')
            ->leftJoin('service_products', 'service_products.id', '=', 'invoice_details.service_products_id')
            ->select(
                'invoice_details.*',
                'service_products.service_products_name',
                'service_products.service_products_category'
            )
            ->where('invoice_details.invoice_id', $invoice_id)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Detail invoice berhasil diambil berdasarkan invoice_id.',
            'data' => $details
        ]);
    }
}
