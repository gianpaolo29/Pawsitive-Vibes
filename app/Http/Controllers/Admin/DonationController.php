<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('items.product')->get();

        return view('admin.donations.index', compact('donations'));
    }

    public function verify(Donation $donation)
    {
        $donation->update(['is_verified' => 1]);

        if ($donation->type === 'products') {
            $donation->load('items.product');

            foreach ($donation->items as $item) {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        return redirect()->route('admin.donations.index');
    }
}
