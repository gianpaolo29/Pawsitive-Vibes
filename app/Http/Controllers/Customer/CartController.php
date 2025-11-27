<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;


class CartController extends Controller
{
    public function index()
    {
        return view('customer.cart.show');
    }
}
