<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        $favorites = Favorite::with(['product.category'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(16);

        // For cart button states (like in shop)
        $cart       = session('cart', []);
        $inCartIds  = array_map('intval', array_keys($cart));

        return view('customer.favorites.show', [
            'favorites' => $favorites,
            'inCartIds' => $inCartIds,
        ]);
    }


    /**
     * Toggle a product as favorite (add/remove).
     */
    public function toggle(Product $product)
    {
        if (! Auth::check()) {
            return redirect()->back()->with('error', 'Please login first.');
        }

        $user = Auth::user();

        $existing = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();

            if (request()->wantsJson()) {
                return response()->json(['favorited' => false, 'message' => 'Removed from favorites.']);
            }
            return back()->with('success', 'Removed from favorites.');
        }

        Favorite::create([
            'user_id'    => $user->id,
            'product_id' => $product->id,
        ]);

        if (request()->wantsJson()) {
            return response()->json(['favorited' => true, 'message' => 'Added to favorites.']);
        }
        return back()->with('success', 'Added to favorites.');
    }
}
