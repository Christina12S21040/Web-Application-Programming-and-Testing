<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::all();
        $formattedProducts = $products->map(function ($product) {
            return [
                'product' => $product,
                'links' => $product->getLinks(),
            ];
        });

        return response()->json([
            'products' => $formattedProducts,
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([
            'product' => $product,
            'links' => $product->getLinks(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_description' => '',
            'product_code' => 'required|min:6|unique:product',
            'product_price' => 'required|numeric',
            'product_stock' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $product = Product::create($request->all());
        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_description' => '',
            'product_code' => 'required|min:6|unique:product',
            'product_price' => 'required|numeric',
            'product_stock' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $product->update($request->all());
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        } else {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        }
    }
}
