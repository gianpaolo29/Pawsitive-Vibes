<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $endDate   = $request->input('end_date')   ? Carbon::parse($request->input('end_date'))->endOfDay()     : null;
        $hasRange  = $startDate && $endDate;

        /*
        |--------------------------------------------------------------------------
        | TOP METRICS
        |--------------------------------------------------------------------------
        */
        $revenueQuery = Transaction::where('payment_status', 'paid');
        if ($hasRange) $revenueQuery->whereBetween('created_at', [$startDate, $endDate]);
        $totalRevenue = $revenueQuery->sum('grand_total');

        $profitQuery = DB::table('transaction_items')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->where('transactions.payment_status', 'paid');
        if ($hasRange) $profitQuery->whereBetween('transactions.created_at', [$startDate, $endDate]);
        $totalProfit = $profitQuery->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));

        $aovQuery = Transaction::where('payment_status', 'paid');
        if ($hasRange) $aovQuery->whereBetween('created_at', [$startDate, $endDate]);
        $avgOrderValue = $aovQuery->avg('grand_total') ?? 0;

        $custQuery = User::where('role', 'customer');
        if ($hasRange) $custQuery->whereBetween('created_at', [$startDate, $endDate]);
        $totalCustomers = $custQuery->count();

        /*
        |--------------------------------------------------------------------------
        | REVENUE & PROFIT TREND (LAST 12 MONTHS OR DATE RANGE)
        |--------------------------------------------------------------------------
        */
        if ($hasRange) {
            $start = $startDate->copy()->startOfMonth();
            $end   = $endDate->copy()->startOfMonth();
            $months = collect();
            while ($start->lte($end)) {
                $months->push($start->copy());
                $start->addMonth();
            }
        } else {
            $months = collect(range(11, 0))->map(fn ($i) => now()->copy()->subMonths($i));
        }

        $labels = [];
        $revenueData = [];
        $profitData = [];

        foreach ($months as $m) {
            $labels[] = $m->format('M Y');

            $rq = Transaction::whereYear('created_at', $m->year)
                ->whereMonth('created_at', $m->month)
                ->where('payment_status', 'paid');
            $revenueData[] = $rq->sum('grand_total');

            $pq = DB::table('transaction_items')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->join('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                ->whereYear('transactions.created_at', $m->year)
                ->whereMonth('transactions.created_at', $m->month)
                ->where('transactions.payment_status', 'paid');
            $profitData[] = $pq->sum(DB::raw('(products.price - products.cost_price) * transaction_items.quantity'));
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUCT ANALYTICS
        |--------------------------------------------------------------------------
        */
        $topProductsQuery = DB::table('products')
            ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id');
        if ($hasRange) {
            $topProductsQuery->leftJoin('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                ->whereBetween('transactions.created_at', [$startDate, $endDate]);
        }
        $topProducts = $topProductsQuery
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
        $custTrendQuery = User::where('role', 'customer');
        if ($hasRange) $custTrendQuery->whereBetween('created_at', [$startDate, $endDate]);
        $newCustomerTrend = $custTrendQuery
            ->select(DB::raw('COUNT(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topCustQuery = Transaction::select('user_id', DB::raw('SUM(grand_total) as total'))->with('user');
        if ($hasRange) $topCustQuery->whereBetween('created_at', [$startDate, $endDate]);
        $topCustomers = $topCustQuery->groupBy('user_id')->orderByDesc('total')->take(10)->get();

        /*
        |--------------------------------------------------------------------------
        | PAYMENT ANALYTICS
        |--------------------------------------------------------------------------
        */
        $payQuery = Payment::select('method', DB::raw('COUNT(*) as total'));
        if ($hasRange) {
            $payQuery->whereHas('transaction', fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]));
        }
        $payments = $payQuery->groupBy('method')->get();

        $totalOrders = Transaction::when($hasRange, fn ($q) => $q->whereBetween('created_at', [$startDate, $endDate]))->count();

        return view('admin.analytics', compact(
            'totalRevenue', 'totalProfit', 'avgOrderValue', 'totalCustomers',
            'labels', 'revenueData', 'profitData',
            'topProducts', 'lowProducts',
            'inventoryValue', 'inventoryPotentialProfit',
            'newCustomerTrend', 'topCustomers',
            'payments', 'startDate', 'endDate', 'hasRange', 'totalOrders'
        ));
    }

    /**
     * Export analytics report as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $endDate   = $request->input('end_date')   ? Carbon::parse($request->input('end_date'))->endOfDay()     : null;
        $hasRange  = $startDate && $endDate;

        $dateLabel = $hasRange
            ? $startDate->format('M d, Y') . ' - ' . $endDate->format('M d, Y')
            : 'All Time';

        $filename = 'analytics-report-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($startDate, $endDate, $hasRange, $dateLabel) {
            $handle = fopen('php://output', 'w');

            // Header
            fputcsv($handle, ['Pawsitive Vibes - Analytics Report']);
            fputcsv($handle, ['Date Range: ' . $dateLabel]);
            fputcsv($handle, ['Generated: ' . now()->format('M d, Y h:i A')]);
            fputcsv($handle, []);

            // KPI Summary
            $revenueQ = Transaction::where('payment_status', 'paid');
            if ($hasRange) $revenueQ->whereBetween('created_at', [$startDate, $endDate]);
            $totalRevenue = $revenueQ->sum('grand_total');

            $ordersQ = Transaction::query();
            if ($hasRange) $ordersQ->whereBetween('created_at', [$startDate, $endDate]);
            $totalOrders = $ordersQ->count();

            $avgOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            fputcsv($handle, ['=== SUMMARY ===']);
            fputcsv($handle, ['Metric', 'Value']);
            fputcsv($handle, ['Total Revenue', number_format($totalRevenue, 2)]);
            fputcsv($handle, ['Total Orders', $totalOrders]);
            fputcsv($handle, ['Average Order Value', number_format($avgOrder, 2)]);
            fputcsv($handle, []);

            // Top Products
            $topProducts = DB::table('products')
                ->leftJoin('transaction_items', 'products.id', '=', 'transaction_items.product_id');
            if ($hasRange) {
                $topProducts->leftJoin('transactions', 'transactions.id', '=', 'transaction_items.transaction_id')
                    ->whereBetween('transactions.created_at', [$startDate, $endDate]);
            }
            $topProducts = $topProducts
                ->select('products.name', DB::raw('COALESCE(SUM(transaction_items.quantity), 0) as total'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total')
                ->take(10)
                ->get();

            fputcsv($handle, ['=== TOP SELLING PRODUCTS ===']);
            fputcsv($handle, ['Product', 'Qty Sold']);
            foreach ($topProducts as $p) {
                fputcsv($handle, [$p->name, $p->total]);
            }
            fputcsv($handle, []);

            // All Orders
            $orders = Transaction::with('user');
            if ($hasRange) $orders->whereBetween('created_at', [$startDate, $endDate]);
            $orders = $orders->orderByDesc('created_at')->get();

            fputcsv($handle, ['=== ORDERS ===']);
            fputcsv($handle, ['Order #', 'Customer', 'Total', 'Payment Method', 'Payment Status', 'Status', 'Date']);
            foreach ($orders as $o) {
                fputcsv($handle, [
                    $o->order_number,
                    $o->user?->fname . ' ' . $o->user?->lname,
                    number_format($o->grand_total, 2),
                    $o->payment_method,
                    $o->payment_status,
                    $o->status,
                    $o->created_at?->format('M d, Y h:i A'),
                ]);
            }
            fputcsv($handle, []);

            // Low Stock
            $lowStock = Product::where('stock', '<=', 10)->orderBy('stock')->get();
            fputcsv($handle, ['=== LOW STOCK PRODUCTS ===']);
            fputcsv($handle, ['Product', 'Stock', 'Price', 'Cost Price']);
            foreach ($lowStock as $p) {
                fputcsv($handle, [$p->name, $p->stock, number_format($p->price, 2), number_format($p->cost_price, 2)]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
