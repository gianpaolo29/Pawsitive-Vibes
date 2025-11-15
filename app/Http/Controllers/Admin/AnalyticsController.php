<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;

class AnalyticsController extends Controller
{
    public function index()
    {
        $now = now();

        /*
        |--------------------------------------------------------------------------
        | TOP METRICS
        |--------------------------------------------------------------------------
        */
        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('grand_total');

        $totalProfit = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.payment_status', 'paid')
            ->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));

        $avgOrderValue = Transaction::where('payment_status','paid')->avg('grand_total') ?? 0;

        $totalCustomers = User::where('role', 'customer')->count();

        /*
        |--------------------------------------------------------------------------
        | REVENUE & PROFIT TREND (LAST 12 MONTHS)
        |--------------------------------------------------------------------------
        */
        $months = collect(range(11, 0))->map(function ($i) {
            return now()->copy()->subMonths($i);
        });

        $labels = [];
        $revenueData = [];
        $profitData = [];

        foreach ($months as $m) {
            $labels[] = $m->format('M Y');

            $revenue = Transaction::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)
                ->where('payment_status', 'paid')
                ->sum('grand_total');

            $profit = DB::table('transaction_items')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                ->whereYear('transactions.created_at', $m->year)
                ->whereMonth('transactions.created_at', $m->month)
                ->where('transactions.payment_status', 'paid')
                ->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));

            $revenueData[] = $revenue;
            $profitData[] = $profit;
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUCT ANALYTICS
        |--------------------------------------------------------------------------
        */
        $topProducts = DB::table('products')
            ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->select('products.name', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        $lowProducts = Product::orderBy('stock')->take(10)->get();

        $inventoryValue = Product::sum(DB::raw('stock * cost_price'));
        $inventoryPotentialProfit = Product::sum(DB::raw('stock * (price - cost_price)'));

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER ANALYTICS
        |--------------------------------------------------------------------------
        */
        $newCustomerTrend = User::where('role', 'customer')
            ->select(DB::raw('COUNT(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topCustomers = Transaction::select('user_id', DB::raw('SUM(grand_total) as total'))
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PAYMENT ANALYTICS
        |--------------------------------------------------------------------------
        */
        $payments = Payment::select('method', DB::raw('COUNT(*) as total'))
            ->groupBy('method')
            ->get();

        return view('admin.analytics', compact(
            'totalRevenue', 'totalProfit', 'avgOrderValue', 'totalCustomers',
            'labels', 'revenueData', 'profitData',
            'topProducts', 'lowProducts',
            'inventoryValue', 'inventoryPotentialProfit',
            'newCustomerTrend', 'topCustomers',
            'payments'
        ));
    }
}
