<?php

namespace App\Http\Controllers\API\ServiceProducts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceProducts;

class ServiceProductsController extends Controller
{
    /**
     * GET /api/service-products
     * Menampilkan semua data service laundry
     */
    public function index()
    {
        $services = ServiceProducts::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar service laundry berhasil diambil.',
            'data' => $services
        ]);
    }

    /**
     * POST /api/service-products
     * Menambahkan service laundry baru
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'service_products_name' => 'required|string|max:255',
            'service_products_price' => 'required|numeric|min:0',
            'service_products_weight' => 'required|numeric|min:0',
            'service_products_category' => 'required|string|max:255',
            'products_id' => 'required|integer'
        ]);

        $service = ServiceProducts::create([
            'service_products_name' => $request->service_products_name,
            'service_products_price' => $request->service_products_price,
            'service_products_weight' => $request->service_products_weight,
            'service_products_category' => $request->service_products_category,
            'products_id' => $request->products_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service laundry berhasil ditambahkan.',
            'data' => $service
        ], 201);
    }

    /**
     * GET /api/service-products/{id}
     * Menampilkan detail service berdasarkan ID
     */
    public function show($id)
    {
        $service = ServiceProducts::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service laundry tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    /**
     * PUT /api/service-products/{id}
     * Mengupdate data service laundry
     */
    public function update(Request $request, $id)
    {
        $service = ServiceProducts::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service laundry tidak ditemukan.'
            ], 404);
        }

        $this->validate($request, [
            'service_products_name' => 'sometimes|required|string|max:255',
            'service_products_price' => 'sometimes|required|numeric|min:0',
            'service_products_weight' => 'sometimes|required|numeric|min:0',
            'service_products_category' => 'sometimes|required|string|max:255',
            'products_id' => 'sometimes|required|integer'
        ]);

        $service->update($request->only([
            'service_products_name',
            'service_products_price',
            'service_products_weight',
            'service_products_category',
            'products_id'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Service laundry berhasil diperbarui.',
            'data' => $service
        ]);
    }

    /**
     * DELETE /api/service-products/{id}
     * Menghapus service laundry
     */
    public function destroy($id)
    {
        $service = ServiceProducts::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service laundry tidak ditemukan.'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service laundry berhasil dihapus.'
        ]);
    }
}
