<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('user.market.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('user.market.show', compact('product'));
    }
}
