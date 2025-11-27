<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;


class DonateController extends Controller
{
    public function index()
    {
        return view('customer.donate.show');
    }
}
