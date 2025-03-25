<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\ProductUpdated;

class ProductController extends Controller
{
    public function fetchProducts()
    {
        $response = Http::get('https://fakestoreapi.com/products');
        $products = $response->json();
        foreach ($products as $item) {
            $product = Product::updateOrCreate(
                ['name' => $item['title']],
                [
                    'description' => $item['description'],
                    'price' => $item['price']
                ]
            );

            broadcast(new ProductUpdated($product))->toOthers();
        }

        return response()->json(['message' => 'Products fetched and stored successfully!']);
    }

    public function getProducts()
    {
        return response()->json(Product::all());
    }

    public function updateProduct($id)
    {
        $product = Product::find($id);

        $product->update([
            'name' => 'Updated Product',
            'price' => 20.00,
        ]);

        broadcast(new ProductUpdated($product))->toOthers();

        return response()->json(['message' => 'Product updated successfully']);
    }

}
