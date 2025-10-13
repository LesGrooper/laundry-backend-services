<?php

namespace App\Http\Controllers\API\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customers;
use Illuminate\Support\Facades\Storage;

class CustomersController extends Controller
{
    /**
     * GET /api/customers
     * Menampilkan semua data customer
     */
    public function index()
    {
        $customers = Customers::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar customer berhasil diambil.',
            'data' => $customers
        ]);
    }

    /**
     * POST /api/customers
     * Menambahkan data customer baru
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'customers_name' => 'required|string|max:255',
            'customers_phone_number' => 'required|string|max:20|unique:customers,customers_phone_number',
            'customers_address' => 'nullable|string|max:255',
            'customers_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('customers_image')) {
            $file = $request->file('customers_image');
            $path = $file->store('customers', 'public'); 
            $data['customers_image'] = $path;
        }

        $customer = Customers::create([
            'customers_name' => $request->customers_name,
            'customers_address' => $request->customers_address,
            'customers_phone_number' => $request->customers_phone_number,
            'customers_image' => $request->customers_image
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil ditambahkan.',
            'data' => $customer
        ], 201);
    }

    /**
     * GET /api/customers/{id}
     * Menampilkan detail customer berdasarkan ID
     */
    public function show($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    /**
     * PUT /api/customers/{id}
     * Mengupdate data customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan.'
            ], 404);
        }

        $this->validate($request, [
            'customers_name' => 'sometimes|required|string|max:255',
            'customers_phone_number' => 'sometimes|required|string|max:20|unique:customers,customers_phone_number,' . $id,
            'customers_address' => 'nullable|string|max:255',
            'customers_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('customers_image')) {
            if ($customer->customers_image && Storage::disk('public')->exists($customer->customers_image)) {
                Storage::disk('public')->delete($customer->customers_image);
            }

            $file = $request->file('customers_image');
            $path = $file->store('customers', 'public');
            $data['customers_image'] = $path;
        }

        $customer->update($request->only([
            'customers_name',
            'customers_address',
            'customers_phone_number',
            'customers_image'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil diperbarui.',
            'data' => $customer
        ]);
    }

    /**
     * DELETE /api/customers/{id}
     * Menghapus customer
     */
    public function destroy($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan.'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus.'
        ]);
    }
}
