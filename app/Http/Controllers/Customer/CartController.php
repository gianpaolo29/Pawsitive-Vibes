<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the cart page
     */
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // Get or create single cart for this user
        $cart = Cart::with(['items.product'])
            ->firstOrCreate([
                'user_id' => $user->id,
            ]);

        $items = $cart->items;

        $total = $items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });

        return view('customer.cart.show', [
            'cart'  => $cart,
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * Add product to cart (Add to Cart button)
     * ⚠️ No stock restriction – can add even if stock is 0 or lower than quantity.
     */
    public function store(Request $request, $productId)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $user = Auth::user();

        // Still respect is_active, pero hindi na tinitingnan ang stock
        $product = Product::findOrFail($productId);

        $quantity = (int) $request->input('quantity', 1);

        // Get or create user cart
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);

        // Check if product already in cart
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // No clamping vs stock — just add quantity
            $item->quantity   = $item->quantity + $quantity;
            $item->unit_price = $product->price; // keep latest price
            $item->save();
        } else {
            // Avoid fillable issues: set manually
            $item = new CartItem();
            $item->cart_id    = $cart->id;
            $item->product_id = $product->id;
            $item->quantity   = $quantity;
            $item->unit_price = $product->price;
            $item->save();
        }

        return back()->with('success', 'Product added to cart.');
    }

    /**
     * Update quantity of an item in the cart
     * ⚠️ Also no stock restriction here.
     */
    public function update(Request $request, CartItem $item)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $user = Auth::user();

        // Make sure this cart item belongs to the logged-in user
        if ($item->cart->user_id !== $user->id) {
            abort(403);
        }

        $product  = $item->product;
        $quantity = (int) $request->input('quantity');
        $item->quantity   = $quantity;
        $item->unit_price = $product->price;
        $item->save();

        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart
     */
    public function destroy(CartItem $item)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // Ensure this item is from the user's cart
        if ($item->cart->user_id !== $user->id) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
