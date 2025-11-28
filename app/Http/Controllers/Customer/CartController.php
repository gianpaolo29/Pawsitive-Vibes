<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        $product = Product::where('is_active', 1)->findOrFail($productId);

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



    public function checkout(Request $request)
    {
        // Validate request
        $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required|string',
            'receipt_image' => 'nullable|image|max:2048',
        ]);

        $orderNumber = 'POS-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        $subTotal = 0;

        // Start a transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // 1️⃣ Validate stock before creating transaction
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    throw new \Exception("Product ID {$item['product_id']} not found.");
                }
                    

                if ($item['qty'] > $product->stock) {
                    throw new \Exception("Not enough stock for product {$product->name}. Available: {$product->stock}");
                }
            }

            // 2️⃣ Compute subtotal
            foreach ($request->items as $item) {
                $subTotal += $item['price'] * $item['qty'];
            }

            $grandTotal = $subTotal; // add taxes, discounts, shipping if needed

            // 3️⃣ Create Transaction
            $transaction = Transaction::create([
                'user_id'      => auth()->id(),
                'order_number' => $orderNumber,
                'subtotal'     => $subTotal,
                'grand_total'  => $grandTotal,
                'payment_method'=> $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'Unpaid': 'For Verification',
                'status'       => 'Pending',
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                $lineTotal = $item['qty'] * $item['price'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['qty'],
                    'line_total'     => $lineTotal,
                ]);

                // Reduce stock
                $product->decrement('stock', $item['qty']);
            }

        // Handle optional receipt image
        $receiptUrl = null;
        if ($request->hasFile('receipt_image')) {
            $path = $request->file('receipt_image')->store('receipts', 'public');
            $receiptUrl = '/storage/' . $path;
        }

        // 6️⃣ Create Payment record
        Payment::create([
            'transaction_id'    => $transaction->id,
            'method'            => $request->payment_method,
            'amount'            => $grandTotal,
            'status'            => 'pending',
            'receipt_image_url' => $receiptUrl,
            'provider_ref'      => null,
        ]);

        // 7️⃣ Clear cart
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
        }

        DB::commit();
            try {
                if (strtolower($request->payment_method) === 'gcash') {
                    $admins = User::where('role', 'ADMIN')->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new GcashPaymentPending($transaction));
                    }
                }
            } catch (\Throwable $e) {
                // optional: \Log::warning('Failed to send admin notifications', ['error' => $e->getMessage()]);
            }

            return redirect()
                ->back()
                ->with('success', 'Checkout completed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }
}
());
        }
    }
}