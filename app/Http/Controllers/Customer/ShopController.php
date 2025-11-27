<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
        ->where('is_active', true)   // ✅ only active products
        ->where('stock', '>', 0);    // ✅ only products with stock

        // 🔎 SEARCH
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 💰 PRICE RANGE
        if ($min = $request->input('min_price')) {
            $query->where('price', '>=', $min);
        }

        if ($max = $request->input('max_price')) {
            $query->where('price', '<=', $max);
        }

        // 🏷️ CATEGORIES (checkboxes)
        $categoryIds = (array) $request->input('category', []);
        if (! empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        // 🔽 SORTING
        $sort = $request->input('sort', 'newest');

        switch ($sort) {
            case 'price-low':      // Price: Low to High
                $query->orderBy('price', 'asc');
                break;

            case 'price-high':     // Price: High to Low
                $query->orderBy('price', 'desc');
                break;

            case 'popular':        // Popular products
                // adjust 'sold_count' to whatever field you actually have (e.g. 'views', 'orders_count', etc.)
                $query->orderBy('sold_count', 'desc')
                      ->orderBy('created_at', 'desc');
                break;

            case 'recommended':    // Recommended / featured
                // adjust 'is_featured' to match your column (tinyint/boolean)
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
                break;

            case 'newest':         // Newest first
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 📄 PAGINATION (keep filters in query string)
        $products = $query->paginate(16)->withQueryString();

        // 📂 CATEGORIES
        $categories = Category::orderBy('name')->get();

        // 🛒 CART MAP: product_id => cart_item_id
        $cartItemIdsByProduct = [];

        if (Auth::check()) {
            $cart = Cart::with('items')->firstOrCreate([
                'user_id' => Auth::id(),
            ]);

            $cartItemIdsByProduct = $cart->items
                ->pluck('id', 'product_id')   // [product_id => cart_item_id]
                ->toArray();
        }

        return view('customer.shop.show', [
            'products'             => $products,
            'categories'           => $categories,
            'cartItemIdsByProduct' => $cartItemIdsByProduct,
        ]);
    }
}
