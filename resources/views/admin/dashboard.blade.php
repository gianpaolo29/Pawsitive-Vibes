<x-admin-layout>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

    {{-- TOP KPI CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        {{-- Revenue + Profit --}}
        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-purple-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">This Month Revenue</p>
                <p class="text-3xl font-bold text-gray-900">
                    ₱{{ number_format($currentRevenue, 2) }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    Last month: ₱{{ number_format($lastRevenue, 2) }}
                </p>
                <p class="text-xs text-emerald-600 mt-1">
                    Profit: ₱{{ number_format($currentProfit, 2) }}
                    @if(!is_null($profitMargin))
                        • Margin: {{ $profitMargin }}%
                    @endif
                </p>
            </div>
            <div class="flex flex-col items-end">
                @if(!is_null($revenueChange))
                    @php $revUp = $revenueChange >= 0; @endphp
                    <span class="font-semibold text-sm {{ $revUp ? 'text-green-500' : 'text-red-500' }}">
                        {{ $revUp ? '+' : '' }}{{ $revenueChange }}%
                    </span>
                @else
                    <span class="text-xs text-gray-400">No data</span>
                @endif>
                <svg class="h-8 w-8 text-purple-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 7v1m-5 0h1m-1-4h1m8-4h1m-1 4h1m-2.599-4C10.92 6.402 10 5.42 10 4.5 10 3.58 10.92 3 12 3s2 .58 2 1.5c0 .92-.92 1.901-2.599 2.599z"/>
                </svg>
            </div>
        </div>

        {{-- Orders --}}
        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-green-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">This Month Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ $currentOrders }}</p>
                <p class="text-xs text-gray-500 mt-1">Last month: {{ $lastOrders }}</p>
            </div>
            <div class="flex flex-col items-end">
                @if(!is_null($ordersChange))
                    @php $ordUp = $ordersChange >= 0; @endphp
                    <span class="font-semibold text-sm {{ $ordUp ? 'text-green-500' : 'text-red-500' }}">
                        {{ $ordUp ? '+' : '' }}{{ $ordersChange }}%
                    </span>
                @else
                    <span class="text-xs text-gray-400">No data</span>
                @endif
                <svg class="h-8 w-8 text-green-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        {{-- New Customers --}}
        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-indigo-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">New Customers</p>
                <p class="text-3xl font-bold text-gray-900">{{ $currentNewCustomers }}</p>
                <p class="text-xs text-gray-500 mt-1">Last month: {{ $lastNewCustomers }}</p>
            </div>
            <div class="flex flex-col items-end">
                @if(!is_null($newCustomersChange))
                    @php $custUp = $newCustomersChange >= 0; @endphp
                    <span class="font-semibold text-sm {{ $custUp ? 'text-green-500' : 'text-red-500' }}">
                        {{ $custUp ? '+' : '' }}{{ $newCustomersChange }}%
                    </span>
                @else
                    <span class="text-xs text-gray-400">No data</span>
                @endif
                <svg class="h-8 w-8 text-indigo-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
        </div>

        {{-- Products Sold --}}
        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-yellow-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Products Sold</p>
                <p class="text-3xl font-bold text-gray-900">{{ $currentProductsSold }}</p>
                <p class="text-xs text-gray-500 mt-1">Last month: {{ $lastProductsSold }}</p>
            </div>
            <div class="flex flex-col items-end">
                @if(!is_null($productsSoldChange))
                    @php $prodUp = $productsSoldChange >= 0; @endphp
                    <span class="font-semibold text-sm {{ $prodUp ? 'text-green-500' : 'text-red-500' }}">
                        {{ $prodUp ? '+' : '' }}{{ $productsSoldChange }}%
                    </span>
                @else
                    <span class="text-xs text-gray-400">No data</span>
                @endif
                <svg class="h-8 w-8 text-yellow-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- SECOND ROW: Sales chart + Status / Payment breakdown --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Sales Overview (Flowbite / Chart.js line) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Sales (Last 7 Days)</h2>
                <p class="text-xs text-gray-500">
                    Total: ₱{{ number_format(array_sum($salesChart['data']), 2) }}
                </p>
            </div>
            <div class="w-full h-64">
                <canvas id="sales-line-chart"></canvas>
            </div>
        </div>

        {{-- Orders by status + payment method --}}
        <div class="bg-white p-6 rounded-xl shadow-lg space-y-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Orders by Status</h2>
                <div class="w-full h-48">
                    <canvas id="status-donut-chart"></canvas>
                </div>
                <div class="mt-3 space-y-1 text-xs text-gray-600">
                    @foreach($ordersByStatus as $status => $total)
                        <div class="flex justify-between">
                            <span class="capitalize">{{ $status }}</span>
                            <span>{{ $total }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Payments</h2>
                <ul class="text-sm text-gray-700 space-y-1">
                    @forelse($paymentsByMethod as $pm)
                        <li class="flex justify-between">
                            <span class="uppercase">{{ $pm->method }}</span>
                            <span>{{ $pm->total }} orders • ₱{{ number_format($pm->amount, 2) }}</span>
                        </li>
                    @empty
                        <li class="text-xs text-gray-400">No payments yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- REVENUE vs PROFIT (LAST 6 MONTHS) --}}
    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Revenue vs Profit (Last 6 Months)</h2>
                <p class="text-xs text-gray-500 mt-1">
                    See how much of your sales are actual profit each month.
                </p>
            </div>
        </div>

        <div class="w-full h-72">
            <canvas id="profit-revenue-bar-chart"></canvas>
        </div>
    </div>

    {{-- THIRD ROW: Top Products, Popular Categories, Low Stock --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Top Products --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Top Products</h2>
            </div>
            <ul class="divide-y divide-gray-100 text-sm">
                @forelse($topProducts as $p)
                    <li class="py-2 flex justify-between">
                        <span class="text-gray-800">{{ $p->name }}</span>
                        <span class="font-semibold text-gray-900">{{ $p->total }} sold</span>
                    </li>
                @empty
                    <li class="py-2 text-xs text-gray-400">No sales yet.</li>
                @endforelse
            </ul>
        </div>

        {{-- Popular Categories --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Popular Categories</h2>
            </div>
            <ul class="divide-y divide-gray-100 text-sm">
                @forelse($popularCategories as $cat)
                    <li class="py-2 flex justify-between">
                        <span class="text-gray-800">{{ $cat->name }}</span>
                        <span class="font-semibold text-gray-900">{{ $cat->total }} items sold</span>
                    </li>
                @empty
                    <li class="py-2 text-xs text-gray-400">No category sales yet.</li>
                @endforelse
            </ul>
        </div>

        {{-- Low Stock & Out of Stock --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Low Stock Alerts</h2>
                <span class="text-xs text-gray-500">
                    Low: {{ $lowStockCount }} • Out: {{ $outOfStockCount }}
                </span>
            </div>
            <ul class="divide-y divide-gray-100 text-sm">
                @forelse($lowStockProducts as $prod)
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 font-medium">{{ $prod->name }}</p>
                            <p class="text-xs text-gray-500">
                                Category: {{ $prod->category->name ?? '—' }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            Stock: {{ $prod->stock }}
                        </span>
                    </li>
                @empty
                    <li class="py-2 text-xs text-gray-400">No low stock products.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                View All Orders
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($recentOrders as $o)
                        <tr>
                            <td class="px-4 py-2 font-semibold text-purple-600">{{ $o->order_number }}</td>
                            <td class="px-4 py-2">
                                <div class="text-gray-900">{{ $o->user->username ?? 'Walk-in' }}</div>
                                <div class="text-xs text-gray-500">{{ $o->user->email ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-2">₱{{ number_format($o->grand_total, 2) }}</td>
                            <td class="px-4 py-2">
                                <span class="px-3 py-1 text-xs rounded-full
                                    @class([
                                        'bg-yellow-100 text-yellow-800' => $o->status === 'pending',
                                        'bg-green-100 text-green-800'  => $o->status === 'paid' || $o->status === 'completed',
                                        'bg-red-100 text-red-800'      => $o->status === 'cancelled',
                                        'bg-gray-100 text-gray-800'    => $o->status === 'refunded',
                                    ])
                                ">
                                    {{ ucfirst($o->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-xs capitalize text-gray-700">
                                {{ $o->payment?->method ?? '—' }} ({{ $o->payment_status }})
                            </td>
                            <td class="px-4 py-2 text-xs text-gray-500">
                                {{ $o->created_at?->format('M j, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-400 text-sm">
                                No recent orders.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Sales line chart
                const salesCtx = document.getElementById('sales-line-chart');
                if (salesCtx && window.Chart) {
                    new Chart(salesCtx, {
                        type: 'line',
                        data: {
                            labels: @json($salesChart['labels']),
                            datasets: [{
                                label: 'Sales',
                                data: @json($salesChart['data']),
                                fill: true,
                                tension: 0.4,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true },
                            }
                        }
                    });
                }

                // Orders by status donut
                const statusCtx = document.getElementById('status-donut-chart');
                if (statusCtx && window.Chart) {
                    const statusLabels = @json(array_keys($ordersByStatus->toArray()));
                    const statusData   = @json(array_values($ordersByStatus->toArray()));

                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: statusLabels,
                            datasets: [{
                                data: statusData,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                }

                // Revenue vs Profit (bar chart)
                const prCtx = document.getElementById('profit-revenue-bar-chart');
                if (prCtx && window.Chart) {
                    new Chart(prCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($profitRevenueChart['labels']),
                            datasets: [
                                {
                                    label: 'Revenue',
                                    data: @json($profitRevenueChart['revenue']),
                                    backgroundColor: 'rgba(129, 140, 248, 0.7)', // indigo
                                },
                                {
                                    label: 'Profit',
                                    data: @json($profitRevenueChart['profit']),
                                    backgroundColor: 'rgba(16, 185, 129, 0.7)', // emerald
                                },
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: { mode: 'index', intersect: false },
                            },
                            scales: {
                                x: { stacked: false },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback(value) {
                                            return '₱' + value;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush

</x-admin-layout>
