<x-admin-layout>
</x-admin-layout>






















<!-- <x-admin-layout>
    @php
        $kpis = [
            'revenue'         => 185000.75,  
            'orders'          => 1423,
            'aov'             => 129.95,     
            'conversion_rate' => 2.84,      
        ];

        $insights = [
            ['trend' => '+', 'text' => 'Lipa City revenue up 25% WoW (₱+38,200).'],
            ['trend' => '+', 'text' => 'AOV up 7% after free shipping threshold tweak.'],
            ['trend' => '-', 'text' => 'Cart abandonments +12% on mobile checkout step.'],
            ['trend' => '+', 'text' => 'Accessories share grew from 14% → 18%.'],
        ];

        $topProducts = [
            ['sku' => 'FOOD-01', 'name' => 'Premium Kibble 10kg', 'qty' => 312, 'revenue' => 156000],
            ['sku' => 'TOY-12',  'name' => 'Chew Rope Large',     'qty' => 201, 'revenue' => 48240],
            ['sku' => 'GRM-07',  'name' => 'Herbal Shampoo 500ml','qty' => 175, 'revenue' => 61250],
            ['sku' => 'ACC-21',  'name' => 'Reflective Leash',    'qty' => 163, 'revenue' => 40750],
        ];

        $lineLabels   = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
        $lineRevenue  = [24000, 21000, 23000, 27000, 32000, 42000, 27000];
        $lineOrders   = [120, 110, 118, 129, 150, 211, 120];

        $donutLabels  = ['Food', 'Toys', 'Grooming', 'Accessories'];
        $donutValues  = [48, 22, 15, 15];

        $funnelLabels = ['Sessions', 'Product Views', 'Add to Cart', 'Checkout', 'Purchases'];
        $funnelValues = [38000, 24000, 9200, 5200, 1080];
    @endphp

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">Analytics</h1>
        <div class="flex items-center gap-2">
            <select class="text-sm border border-gray-300 rounded-lg py-1 px-2">
                <option>Last 7 days</option>
                <option selected>Last 30 days</option>
                <option>Last 90 days</option>
            </select>
            <button class="text-sm px-3 py-1.5 rounded-lg border border-gray-300 hover:bg-gray-50">Export</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-emerald-500">
            <p class="text-gray-500 text-sm">Revenue</p>
            <p class="text-3xl font-bold mt-1">₱{{ number_format($kpis['revenue'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-violet-500">
            <p class="text-gray-500 text-sm">Orders</p>
            <p class="text-3xl font-bold mt-1">{{ number_format($kpis['orders']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <p class="text-gray-500 text-sm">Average Order Value</p>
            <p class="text-3xl font-bold mt-1">₱{{ number_format($kpis['aov'], 2) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-rose-500">
            <p class="text-gray-500 text-sm">Conversion Rate</p>
            <p class="text-3xl font-bold mt-1">{{ number_format($kpis['conversion_rate'], 2) }}%</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Revenue & Orders Line (2/3) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Revenue & Orders (Last 7 days)</h2>
            </div>
            <div class="h-72">
                <canvas id="revOrdersLine"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Category Share</h2>
            </div>
            <div class="h-72">
                <canvas id="categoryDonut"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Funnel --}}
        <div class="bg-white rounded-xl shadow p-6 lg:col-span-1">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Conversion Funnel</h2>
            </div>
            <div class="h-72">
                <canvas id="funnelBar"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Smart Insights Feed</h2>
            </div>

            {{-- Insights table (forced visible with borders/colors) --}}
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left w-24">Trend</th>
                            <th class="px-4 py-2 text-left">Insight</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($insights as $i)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    @if($i['trend'] === '+')
                                        <span class="text-emerald-600 font-semibold">▲</span>
                                    @else
                                        <span class="text-rose-600 font-semibold">▼</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $i['text'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <h3 class="text-base font-semibold mt-6 mb-3 text-gray-900">Top Products</h3>
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full text-sm text-gray-800">
                    <thead class="text-gray-600 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">SKU</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-right">Qty</th>
                            <th class="px-4 py-2 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($topProducts as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $p['sku'] }}</td>
                                <td class="px-4 py-2">{{ $p['name'] }}</td>
                                <td class="px-4 py-2 text-right">{{ number_format($p['qty']) }}</td>
                                <td class="px-4 py-2 text-right">₱{{ number_format($p['revenue'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    (() => {

        const lineLabels  = @json($lineLabels);
        const lineRevenue = @json($lineRevenue);
        const lineOrders  = @json($lineOrders);

        const donutLabels = @json($donutLabels);
        const donutValues = @json($donutValues);

        const funnelLabels = @json($funnelLabels);
        const funnelValues = @json($funnelValues);

        const primaryColor   = '#10b981'; 
        const secondaryColor = '#8b5cf6'; 
        const accentColors   = ['#f59e0b', '#ef4444', '#14b8a6', '#4f46e5', '#ec4899'];

       
        const lineCtx = document.getElementById('revOrdersLine').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: lineLabels,
                datasets: [
                    {
                        label: 'Revenue (₱)',
                        data: lineRevenue,
                        borderWidth: 2,
                        tension: 0.35,
                        borderColor: primaryColor,
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        fill: true,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Orders',
                        data: lineOrders,
                        borderWidth: 2,
                        tension: 0.35,
                        borderColor: secondaryColor,
                        backgroundColor: 'rgba(139, 92, 246, 0.2)',
                        fill: false,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: true } },
                scales: {
                    y:  { beginAtZero: true, title: { display: true, text: 'Revenue (₱)' } },
                    y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Orders' } }
                }
            }
        });

        const donutCtx = document.getElementById('categoryDonut').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: donutLabels,
                datasets: [{
                    data: donutValues,
                    backgroundColor: [primaryColor, secondaryColor, accentColors[2], accentColors[4]],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.label || ''}: ${ctx.parsed || 0}%`
                        }
                    }
                }
            }
        });

        const funnelCtx = document.getElementById('funnelBar').getContext('2d');
        new Chart(funnelCtx, {
            type: 'bar',
            data: {
                labels: funnelLabels,
                datasets: [{
                    label: 'Count',
                    data: funnelValues,
                    borderWidth: 1,
                    backgroundColor: [
                        '#94a3b8', 
                        '#60a5fa', 
                        '#fcd34d',
                        '#a855f7', 
                        primaryColor
                    ],
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true } }
            }
        });
    })();
    </script>
</x-admin-layout> -->
