<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\ProductEvent;

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
                    'price' => $item['price'],
                    'category' => $item['category'],
                    'image' => $item['image'],
                    'rating_rate' => $item['rating']['rate'],
                    'rating_count' => $item['rating']['count']
                ]
            );

            broadcast(new ProductEvent($product))->toOthers();
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

        broadcast(new ProductEvent($product))->toOthers();

        return response()->json(['message' => 'Product updated successfully']);
    }

}
