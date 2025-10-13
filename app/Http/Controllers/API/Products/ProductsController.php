<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * GET /api/products
     * Menampilkan semua produk
     */
    public function index()
    {
        $products = Products::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar produk berhasil diambil.',
            'data' => $products
        ]);
    }

    /**
     * POST /api/products
     * Menambahkan produk baru
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'products_name' => 'required|string|max:255',
            'products_description' => 'nullable|string|max:255',
            'products_price' => 'required|numeric|min:0',
            'products_image' => 'nullable|string|max:255',
            'customers_id' => 'nullable|integer|max:255'
        ]);

        $product = Products::create([
            'products_name' => $request->products_name,
            'products_description' => $request->products_description,
            'products_price' => $request->products_price,
            'products_image' => $request->products_image,
            'customers_id' => $request->customers_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'data' => $product
        ], 201);
    }

    /**
     * GET /api/products/{id}
     * Menampilkan detail produk berdasarkan ID
     */
    public function show($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * PUT /api/products/{id}
     * Mengupdate data produk
     */
    public function update(Request $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        $this->validate($request, [
            'products_name' => 'sometimes|required|string|max:255',
            'products_description' => 'nullable|string|max:255',
            'products_price' => 'sometimes|required|numeric|min:0',
            'products_image' => 'nullable|string|max:255',
            'customers_id' => 'nullable|integer|max:255'
        ]);

        $product->update($request->only([
            'products_name',
            'products_description',
            'products_price',
            'products_image',
            'customers_id'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui.',
            'data' => $product
        ]);
    }

    /**
     * DELETE /api/products/{id}
     * Menghapus produk
     */
    public function destroy($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus.'
        ]);
    }
}
