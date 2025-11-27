<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;


class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        $featuredProducts = Product::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $products = Product::where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view('welcome', [
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'products' => $products,
        ]);
    }
}
