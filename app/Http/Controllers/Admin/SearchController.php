<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $results = [];

        // Products
        $products = Product::where('name', 'like', "%{$q}%")
            ->take(5)
            ->get(['id', 'name', 'stock', 'price']);

        foreach ($products as $p) {
            $results[] = [
                'type'  => 'Product',
                'icon'  => 'product',
                'title' => $p->name,
                'meta'  => 'Stock: ' . $p->stock . ' · ₱' . number_format($p->price, 2),
                'url'   => route('admin.products.edit', $p->id),
            ];
        }

        // Orders
        $orders = Transaction::where('order_number', 'like', "%{$q}%")
            ->orWhere('id', $q)
            ->with('user:id,fname,lname')
            ->take(5)
            ->get();

        foreach ($orders as $o) {
            $customer = $o->user ? $o->user->fname . ' ' . $o->user->lname : 'Unknown';
            $results[] = [
                'type'  => 'Order',
                'icon'  => 'order',
                'title' => $o->order_number,
                'meta'  => $customer . ' · ₱' . number_format($o->grand_total, 2) . ' · ' . $o->status,
                'url'   => route('admin.orders.show', $o->id),
            ];
        }

        // Customers
        $customers = User::where('role', 'CUSTOMER')
            ->where(function ($query) use ($q) {
                $query->where('fname', 'like', "%{$q}%")
                    ->orWhere('lname', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%");
            })
            ->take(5)
            ->get(['id', 'fname', 'lname', 'email']);

        foreach ($customers as $c) {
            $results[] = [
                'type'  => 'Customer',
                'icon'  => 'customer',
                'title' => $c->fname . ' ' . $c->lname,
                'meta'  => $c->email,
                'url'   => route('admin.customers.edit', $c->id),
            ];
        }

        return response()->json(array_slice($results, 0, 12));
    }

    public function customerSuggestions(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $customers = User::where('role', 'CUSTOMER')
            ->where(function ($query) use ($q) {
                $query->where('fname', 'like', "%{$q}%")
                    ->orWhere('lname', 'like', "%{$q}%")
                    ->orWhereRaw("concat(fname,' ',lname) like ?", ["%{$q}%"])
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%");
            })
            ->take(8)
            ->get(['id', 'fname', 'lname', 'email', 'username', 'is_active', 'created_at']);

        return response()->json($customers->map(fn ($c) => [
            'id'       => $c->id,
            'name'     => $c->fname . ' ' . $c->lname,
            'initials' => strtoupper(substr($c->fname, 0, 1) . substr($c->lname, 0, 1)),
            'username' => $c->username,
            'email'    => $c->email,
            'active'   => (bool) $c->is_active,
            'joined'   => $c->created_at?->format('M d, Y'),
            'url'      => route('admin.customers.edit', $c->id),
        ]));
    }
}
