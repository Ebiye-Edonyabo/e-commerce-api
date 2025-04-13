<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->only('title', 'description', 'image', 'price'));
        return response()->json($product, Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->only('title', 'description', 'image', 'price'));
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response('null', Response::HTTP_NO_CONTENT);
    }

    public function frontEnd()
    {

        return Cache::remember('products_frontend', 30 * 60, fn () => Product::all());
    }

    public function backEnd(Request $request)
    {
        // the remember method is to retrieve and store
        // for manually pagiantion
        $page = $request->input(key: 'page', default: 1);
        $products = Cache::remember('products_backend', 30 * 60, fn () => Product::all());

        if( $search = $request->input('search')) {
            $products = $products->filter( function (Product $product) use($search) {
                return Str::contains($product->title, $search, ignoreCase: true) || Str::contains($product->description, $search, ignoreCase: true);
            });
        }
        $total = $products->count();

        return [
            'data' => $products->forPage($page, perPage: 5)->values(),
            'meta' => [
                'total' => $total,
                'page' => $page,
                'last_page' => ceil($total / 5),
            ]
        ];
      
    }
}
