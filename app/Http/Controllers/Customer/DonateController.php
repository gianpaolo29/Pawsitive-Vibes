<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Donation;
use App\Models\DonationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DonateController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();

        return view('customer.donate.show', compact('products'));
    }

    public function store(Request $request)
    {
        // 1. Validate
        $data = $request->validate([
            'type'   => ['required', 'in:products,cash'],

            // Donor info
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255'],
            'phone'  => ['required', 'string', 'max:50'],

            // CASH fields (only if type=cash)
            'amount' => ['required_if:type,cash', 'nullable', 'numeric', 'min:1'],
            'receipt' => ['required_if:type,cash', 'nullable', 'file', 'image', 'max:2048'],

            // PRODUCT fields (only if type=products)
            'products'                => ['required_if:type,products', 'array'],
            'products.*.product_id'   => ['required_if:type,products', 'integer', 'exists:products,id'],
            'products.*.quantity'     => ['required_if:type,products', 'integer', 'min:1'],
        ], [
            // Optional: custom messages (Taglish-friendly)
            'type.required' => 'Please select donation type.',
            'products.required_if' => 'Please add at least one product for product donation.',
            'amount.required_if' => 'Please enter the amount for cash donation.',
        ]);

        return DB::transaction(function () use ($data, $request) {
            $totalAmount = 0;
            $receiptUrl = null;

            // 2. Compute total based on type
            if ($data['type'] === 'products') {
                // Get products from DB to avoid trusting frontend prices
                $productIds = collect($data['products'])->pluck('product_id')->unique()->all();

                $products = Product::whereIn('id', $productIds)
                    ->get(['id', 'price'])
                    ->keyBy('id');

                foreach ($data['products'] as $item) {
                    $product = $products[$item['product_id']] ?? null;
                    if (! $product) {
                        continue; // should not happen because of validation
                    }

                    $lineTotal = $product->price * $item['quantity'];
                    $totalAmount += $lineTotal;
                }
            } else {
                // Cash type
                $totalAmount = (float) ($data['amount'] ?? 0);

                // Handle receipt upload
                if ($request->hasFile('receipt')) {
                    $receiptUrl = $request->file('receipt')->store('receipts', 'public');
                }
            }

            // 3. Create Donation record
            $donation = Donation::create([
                'type'         => $data['type'],
                'name'         => $data['name'],
                'email'        => $data['email'],
                'phone'        => $data['phone'],
                'amount'       => $data['type'] === 'cash' ? $data['amount'] : null,
                'total_amount' => $totalAmount,
                'receipt_url'  => $receiptUrl,
            ]);

            // 4. Create DonationItem records if product-based
            if ($data['type'] === 'products') {
                foreach ($data['products'] as $item) {
                    $product = $products[$item['product_id']] ?? null;
                    if (! $product) {
                        continue;
                    }

                    $product->decrement('stock', $item['quantity']);

                    $lineTotal = $product->price * $item['quantity'];

                    DonationItem::create([
                        'donation_id' => $donation->id,
                        'product_id'  => $item['product_id'],
                        'quantity'    => $item['quantity'],
                        'line_total'  => $lineTotal,
                    ]);
                }
            }

            return redirect()
                ->back()
                ->with('success', 'Thank you for your donation!');
        });
    }
}
