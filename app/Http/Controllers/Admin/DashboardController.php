<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        // Work with month + year (para safe kahit magpalit ng taon)
        $currentMonthDate = $now;
        $lastMonthDate    = $now->copy()->subMonth();

        $currentMonth = $currentMonthDate->month;
        $currentYear  = $currentMonthDate->year;

        $lastMonth    = $lastMonthDate->month;
        $lastYear     = $lastMonthDate->year;

        /*
        |--------------------------------------------------------------------------
        | REVENUE (CURRENT VS LAST MONTH)
        |--------------------------------------------------------------------------
        */
        $currentRevenue = Transaction::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('payment_status', 'Paid')
            ->sum('grand_total');

        $lastRevenue = Transaction::whereYear('created_at', $lastYear)
            ->whereMonth('created_at', $lastMonth)
            ->where('payment_status', 'Paid')
            ->sum('grand_total');

        $revenueChange = $lastRevenue > 0
            ? round((($currentRevenue - $lastRevenue) / $lastRevenue) * 100, 1)
            : null;

        /*
        |--------------------------------------------------------------------------
        | PROFIT (CURRENT VS LAST MONTH)
        | profit = (price - cost_price) * quantity
        |--------------------------------------------------------------------------
        */
        $currentProfit = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereYear('transactions.created_at', $currentYear)
            ->whereMonth('transactions.created_at', $currentMonth)
            ->where('transactions.payment_status', 'Paid')
            ->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));

        $lastProfit = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereYear('transactions.created_at', $lastYear)
            ->whereMonth('transactions.created_at', $lastMonth)
            ->where('transactions.payment_status', 'Paid')
            ->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));

        $profitChange = $lastProfit > 0
            ? round((($currentProfit - $lastProfit) / $lastProfit) * 100, 1)
            : null;

        $profitMargin = $currentRevenue > 0
            ? round(($currentProfit / $currentRevenue) * 100, 1)
            : null;

        /*
        |--------------------------------------------------------------------------
        | ORDERS (CURRENT VS LAST MONTH)
        |--------------------------------------------------------------------------
        */
        $currentOrders = Transaction::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        $lastOrders = Transaction::whereYear('created_at', $lastYear)
            ->whereMonth('created_at', $lastMonth)
            ->count();

        $ordersChange = $lastOrders > 0
            ? round((($currentOrders - $lastOrders) / $lastOrders) * 100, 1)
            : null;

        /*
        |--------------------------------------------------------------------------
        | NEW CUSTOMERS (CURRENT VS LAST MONTH)
        |--------------------------------------------------------------------------
        */
        $currentNewCustomers = User::where('role', 'customer')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        $lastNewCustomers = User::where('role', 'customer')
            ->whereYear('created_at', $lastYear)
            ->whereMonth('created_at', $lastMonth)
            ->count();

        $newCustomersChange = $lastNewCustomers > 0
            ? round((($currentNewCustomers - $lastNewCustomers) / $lastNewCustomers) * 100, 1)
            : null;

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS SOLD (ITEM QTY, CURRENT VS LAST MONTH)
        |--------------------------------------------------------------------------
        */
        $currentProductsSold = TransactionItem::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('quantity');

        $lastProductsSold = TransactionItem::whereYear('created_at', $lastYear)
            ->whereMonth('created_at', $lastMonth)
            ->sum('quantity');

        $productsSoldChange = $lastProductsSold > 0
            ? round((($currentProductsSold - $lastProductsSold) / $lastProductsSold) * 100, 1)
            : null;

        /*
        |--------------------------------------------------------------------------
        | STOCK / TOTALS
        |--------------------------------------------------------------------------
        */
        $totalRevenue    = Transaction::where('payment_status', 'Paid')->sum('grand_total');
        $totalOrders     = Transaction::count();
        $totalCustomers  = User::where('role', 'customer')->count();
        $activeProducts  = Product::where('is_active', true)->count();
        $lowStockCount   = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStockCount = Product::where('stock', '=', 0)->count();

        /*
        |--------------------------------------------------------------------------
        | SALES CHART (LAST 7 DAYS)
        |--------------------------------------------------------------------------
        */
        $startDate = $now->copy()->subDays(6)->startOfDay();

        $rawSales = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as total')
            )
            ->where('payment_status', 'Paid')
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('total', 'date');   // ['2025-11-09' => 1234.00, ...]

        $salesLabels = [];
        $salesData   = [];

        for ($i = 0; $i < 7; $i++) {
            $d   = $startDate->copy()->addDays($i);
            $key = $d->toDateString();

            $salesLabels[] = $d->format('M j');
            $salesData[]   = isset($rawSales[$key]) ? (float) $rawSales[$key] : 0;
        }

        $salesChart = [
            'labels' => $salesLabels,
            'data'   => $salesData,
        ];

        /*
        |--------------------------------------------------------------------------
        | REVENUE vs PROFIT (LAST 6 MONTHS)
        |--------------------------------------------------------------------------
        */
        $months = collect(range(5, 0, -1))->map(function ($i) {
            return now()->copy()->subMonths($i);
        });

        $prLabels  = [];
        $prRevData = [];
        $prProfData = [];

        foreach ($months as $m) {
            $prLabels[] = $m->format('M Y');

            $rev = Transaction::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)
                ->where('payment_status', 'Paid')
                ->sum('grand_total');

            $prof = DB::table('transaction_items')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->whereYear('transactions.created_at', $m->year)
                ->whereMonth('transactions.created_at', $m->month)
                ->where('transactions.payment_status', 'Paid')
                ->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));

            $prRevData[]  = (float) $rev;
            $prProfData[] = (float) $prof;
        }

        $profitRevenueChart = [
            'labels'  => $prLabels,
            'revenue' => $prRevData,
            'profit'  => $prProfData,
        ];

        /*
        |--------------------------------------------------------------------------
        | ORDERS BY STATUS / PAYMENTS / TOP PRODUCTS / POPULAR CATEGORIES
        |--------------------------------------------------------------------------
        */
        $ordersByStatus = Transaction::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $paymentsByMethod = Payment::select(
                'method',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(amount) as amount')
            )
            ->groupBy('method')
            ->get();

        $topProducts = DB::table('products')
            ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $popularCategories = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $recentOrders = Transaction::with(['user', 'payment'])
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'currentRevenue', 'lastRevenue', 'revenueChange',
            'currentProfit', 'lastProfit', 'profitChange', 'profitMargin',
            'currentOrders', 'lastOrders', 'ordersChange',
            'currentNewCustomers', 'lastNewCustomers', 'newCustomersChange',
            'currentProductsSold', 'lastProductsSold', 'productsSoldChange',
            'salesChart', 'profitRevenueChart',
            'ordersByStatus', 'paymentsByMethod',
            'topProducts', 'popularCategories',
            'lowStockProducts', 'lowStockCount', 'outOfStockCount',
            'recentOrders',
            'totalRevenue', 'totalOrders', 'totalCustomers', 'activeProducts'
        ));
    }
}
