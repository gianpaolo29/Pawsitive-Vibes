<x-admin-layout>
    <div class="flex flex-col gap-6">
        {{-- PAGE HEADER --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
                <p class="text-sm text-gray-500">
                    Deep insights for sales, profit, products, customers, and payments.
                    @if($hasRange)
                        <span class="ml-1 font-semibold text-violet-600">
                            ({{ $startDate->format('M d, Y') }} — {{ $endDate->format('M d, Y') }})
                        </span>
                    @else
                        <span class="ml-1 text-gray-400">(All Time)</span>
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.analytics.export', request()->only('start_date', 'end_date')) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold shadow hover:bg-emerald-700">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Export CSV
                </a>
                <button onclick="window.location.reload()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-violet-600 text-white text-sm font-semibold shadow hover:bg-violet-700">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 4v6h6M20 20v-6h-6M5 19A9 9 0 0 1 5 5l1.5 1.5M19 5A9 9 0 0 1 19 19L17.5 17.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        {{-- DATE RANGE FILTER --}}
        <div class="bg-white rounded-xl shadow-sm p-4">
            <form method="GET" action="{{ route('admin.analytics.index') }}" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[160px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date', $startDate?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-violet-500 focus:ring-violet-500">
                </div>
                <div class="flex-1 min-w-[160px]">
                    <label class="block text-xs font-medium text-gray-500 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date', $endDate?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-violet-500 focus:ring-violet-500">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-violet-600 text-white text-sm font-semibold shadow hover:bg-violet-700">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Filter
                    </button>
                    @if($hasRange)
                        <a href="{{ route('admin.analytics.index') }}"
                            class="inline-flex items-center gap-1 px-4 py-2 rounded-lg bg-gray-100 text-gray-700 text-sm font-medium hover:bg-gray-200">
                            Clear
                        </a>
                    @endif
                </div>
                {{-- Quick presets --}}
                <div class="flex items-center gap-2 ml-auto">
                    <span class="text-xs text-gray-400">Quick:</span>
                    <a href="{{ route('admin.analytics.index', ['start_date' => now()->startOfDay()->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium {{ request('start_date') === now()->format('Y-m-d') ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Today
                    </a>
                    <a href="{{ route('admin.analytics.index', ['start_date' => now()->subDays(7)->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200">
                        7 Days
                    </a>
                    <a href="{{ route('admin.analytics.index', ['start_date' => now()->subDays(30)->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200">
                        30 Days
                    </a>
                    <a href="{{ route('admin.analytics.index', ['start_date' => now()->startOfYear()->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}"
                       class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200">
                        This Year
                    </a>
                </div>
            </form>
        </div>

        {{-- TOP KPI CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Revenue --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-violet-500 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ₱{{ number_format($totalRevenue, 2) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $hasRange ? 'Filtered period' : 'All-time' }} paid orders</p>
                </div>
                <div class="p-2 rounded-full bg-violet-50 text-violet-600">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3v18M7 8c0-1.657 1.79-3 5-3s5 1.343 5 3-1.79 3-5 3-5 1.343-5 3 1.79 3 5 3 5-1.343 5-3"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Total Profit --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-emerald-500 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Total Profit</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ₱{{ number_format($totalProfit, 2) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Based on (price - cost_price)</p>
                </div>
                <div class="p-2 rounded-full bg-emerald-50 text-emerald-600">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M4 12l4 4 8-8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- AOV --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-blue-500 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Average Order Value</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ₱{{ number_format($avgOrderValue, 2) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Avg per paid order</p>
                </div>
                <div class="p-2 rounded-full bg-blue-50 text-blue-600">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M3 4h18M7 4v16M17 4v16M3 20h18" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            {{-- Total Customers --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border-t-4 border-amber-500 flex items-start justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-1">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ number_format($totalCustomers) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Registered with role = customer</p>
                </div>
                <div class="p-2 rounded-full bg-amber-50 text-amber-600">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M16 14a4 4 0 10-8 0M4 20a8 8 0 1116 0M12 4a3 3 0 110 6 3 3 0 010-6z"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- SALES & PROFIT TRENDS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Revenue vs Profit Line Chart --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Revenue vs Profit (Last 12 Months)</h2>
                        <p class="text-xs text-gray-500">Monthly total of paid transactions</p>
                    </div>
                </div>
                <div class="w-full h-72">
                    <canvas id="revenue-profit-chart"></canvas>
                </div>
            </div>

            {{-- Inventory Value / Potential Profit --}}
            <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-gray-900">Inventory Insights</h2>

                <div class="flex items-center justify-between bg-violet-50 rounded-lg px-4 py-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500">Inventory Value</p>
                        <p class="text-xl font-bold text-gray-900">
                            ₱{{ number_format($inventoryValue, 2) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Sum of stock × cost price</p>
                    </div>
                    <div class="p-2 rounded-full bg-violet-100 text-violet-700">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M3 7l9-4 9 4-9 4-9-4zM3 17l9 4 9-4M3 12l9 4 9-4"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="flex items-center justify-between bg-emerald-50 rounded-lg px-4 py-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500">Potential Profit</p>
                        <p class="text-xl font-bold text-gray-900">
                            ₱{{ number_format($inventoryPotentialProfit, 2) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">If everything sells at current price</p>
                    </div>
                    <div class="p-2 rounded-full bg-emerald-100 text-emerald-700">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.8">
                            <path d="M4 12l4 4 8-8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mt-2">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">Lowest Stock Products</h3>
                    <ul class="space-y-2 max-h-40 overflow-y-auto text-sm">
                        @forelse($lowProducts as $prod)
                            <li class="flex items-center justify-between">
                                <span class="text-gray-800 truncate">{{ $prod->name }}</span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $prod->stock == 0 ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }}">
                                    Stock: {{ $prod->stock }}
                                </span>
                            </li>
                        @empty
                            <li class="text-xs text-gray-400">No products found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- PRODUCT ANALYTICS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Top Products Chart --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Top Selling Products</h2>
                    <p class="text-xs text-gray-500">Based on quantity sold</p>
                </div>
                <div class="w-full h-72">
                    <canvas id="top-products-chart"></canvas>
                </div>
            </div>

            {{-- Top Products Table --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Top Products (Table)</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm divide-y divide-gray-100">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-right">Qty Sold</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($topProducts as $p)
                                <tr>
                                    <td class="px-4 py-2 text-gray-800">{{ $p->name }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">
                                        {{ $p->total }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-6 text-center text-xs text-gray-400">
                                        No sales data yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- CUSTOMER & PAYMENT ANALYTICS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- New Customer Trend --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">New Customers Over Time</h2>
                    <p class="text-xs text-gray-500">Grouped by month</p>
                </div>
                <div class="w-full h-72">
                    <canvas id="customers-chart"></canvas>
                </div>
            </div>

            {{-- Payment Methods --}}
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Methods</h2>
                <div class="w-full h-56 mb-4">
                    <canvas id="payment-chart"></canvas>
                </div>
                <ul class="text-xs text-gray-600 space-y-1">
                    @forelse($payments as $pm)
                        <li class="flex justify-between">
                            <span class="uppercase">{{ $pm->method }}</span>
                            <span>{{ $pm->total }} payments</span>
                        </li>
                    @empty
                        <li class="text-gray-400">No payment data yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- TOP CUSTOMERS --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Top Customers (by Spend)</h2>
                <p class="text-xs text-gray-500">Based on total amount spent</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-4 py-2 text-left">Customer</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-right">Total Spend</th>
                            <th class="px-4 py-2 text-right">Orders</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topCustomers as $row)
                            <tr>
                                <td class="px-4 py-2 text-gray-800">
                                    {{ $row->user->username ?? 'Unknown' }}
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $row->user->email ?? '—' }}
                                </td>
                                <td class="px-4 py-2 text-right font-semibold">
                                    ₱{{ number_format($row->total, 2) }}
                                </td>
                                <td class="px-4 py-2 text-right text-gray-500">
                                    {{-- Count orders for that user (lazy but fine for now) --}}
                                    {{ \App\Models\Transaction::where('user_id', $row->user_id)->count() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-xs text-gray-400">
                                    No customers yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        {{-- Make sure Chart.js / Flowbite Charts is loaded in your main admin layout --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (!window.Chart) {
                    console.warn('Chart.js not found. Make sure it is loaded in your layout.');
                    return;
                }

                // -------------------------------
                // Revenue vs Profit (Line Chart)
                // -------------------------------
                const revenueProfitCtx = document.getElementById('revenue-profit-chart');
                if (revenueProfitCtx) {
                    new Chart(revenueProfitCtx, {
                        type: 'line',
                        data: {
                            labels: @json($labels),
                            datasets: [
                                {
                                    label: 'Revenue',
                                    data: @json($revenueData),
                                    tension: 0.3,
                                    fill: true,
                                },
                                {
                                    label: 'Profit',
                                    data: @json($profitData),
                                    tension: 0.3,
                                    fill: false,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'top' }
                            },
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                }

                // -------------------------------
                // Top Products (Bar Chart)
                // -------------------------------
                const topProductsCtx = document.getElementById('top-products-chart');
                if (topProductsCtx) {
                    const topProductsLabels = @json($topProducts->pluck('name'));
                    const topProductsData   = @json($topProducts->pluck('total'));

                    new Chart(topProductsCtx, {
                        type: 'bar',
                        data: {
                            labels: topProductsLabels,
                            datasets: [{
                                label: 'Qty Sold',
                                data: topProductsData,
                            }]
                        },
                        options: {
                            responsive: true,
                            indexAxis: 'y',
                            scales: {
                                x: { beginAtZero: true }
                            },
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }

                // -------------------------------
                // New Customers Trend (Line)
                // -------------------------------
                const customersCtx = document.getElementById('customers-chart');
                if (customersCtx) {
                    const custLabels = @json($newCustomerTrend->pluck('month'));
                    const custData   = @json($newCustomerTrend->pluck('total'));

                    new Chart(customersCtx, {
                        type: 'line',
                        data: {
                            labels: custLabels,
                            datasets: [{
                                label: 'New Customers',
                                data: custData,
                                tension: 0.3,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                }

                const paymentCtx = document.getElementById('payment-chart');
                if (paymentCtx) {
                    const payLabels = @json($payments->pluck('method'));
                    const payData   = @json($payments->pluck('total'));

                    new Chart(paymentCtx, {
                        type: 'doughnut',
                        data: {
                            labels: payLabels,
                            datasets: [{
                                data: payData,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-admin-layout>
