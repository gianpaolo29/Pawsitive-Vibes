<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions =  Transaction::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->get();

        dd($transactions->toArray());

        $user = auth()->user();

        return view('customer.profile.transactions', compact('transactions', 'user'));

    }
}
