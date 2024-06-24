<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\RedirectResponse;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('main', [
            'products' => $products
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('product.index');
    }
}
