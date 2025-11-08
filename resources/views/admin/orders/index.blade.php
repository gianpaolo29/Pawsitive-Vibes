<x-admin-layout>
    <div x-data="{ 
        openModal: false, 
        modalData: {},
        expandedRow: null
    }" class="min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Transactions Overview</h1>

            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('admin.orders.create') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 text-white text-base font-semibold rounded-xl shadow-lg hover:bg-violet-700 hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                    New Transaction
                </a>
            </div>
        </div>

        @if(session('ok'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-xl shadow-md border border-green-200 animate-fade-in-down" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('ok') }}
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-blue-500 hover:shadow-xl transition-shadow duration-300 ease-in-out">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalOrders ?? 3847) }}</p>
                </div>
                <div class="ml-auto p-2 bg-blue-50 rounded-full text-blue-500 opacity-70">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-orange-500 hover:shadow-xl transition-shadow duration-300 ease-in-out">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10zM12 8v4M12 16h.01"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Validation</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($pendingValidationCount ?? 42) }}</p>
                    <p class="text-xs font-medium text-orange-600 mt-0.5">GCash payments need review</p>
                </div>
                <div class="ml-auto p-2 bg-orange-50 rounded-full text-orange-500 opacity-70">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18h20.36L13.71 3.86zM12 9v4M12 17h.01"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-emerald-500 hover:shadow-xl transition-shadow duration-300 ease-in-out">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 1v22M17 5H7M17 19H7M19 9h-2M5 9h2M19 15h-2M5 15h2"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">₱{{ number_format($monthlyRevenue ?? 47892) }}</p>
                </div>
                <div class="ml-auto p-2 bg-emerald-50 rounded-full text-emerald-500 opacity-70">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H7M17 19H7M19 9h-2M5 9h2M19 15h-2M5 15h2"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-violet-500 hover:shadow-xl transition-shadow duration-300 ease-in-out">
                <div class="p-3 rounded-full bg-violet-100 text-violet-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 2H2v8l9 9 9-9-8-8zM15 3h6v6"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Ready for Pickup</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($readyForPickupCount ?? 156) }}</p>
                </div>
                <div class="ml-auto p-2 bg-violet-50 rounded-full text-violet-500 opacity-70">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 2H2v8l9 9 9-9-8-8zM15 3h6v6"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            
            <form method="get" class="p-5 bg-gray-50 flex flex-col lg:flex-row items-center lg:items-stretch gap-4 border-b border-gray-100">
                
                <div class="relative w-full lg:w-80">
                    <svg class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 19l-6-6M5 11a6 6 0 1 1 12 0 6 6 0 0 1-12 0z"/></svg>
                    <input name="s" value="{{ request('s') }}" placeholder="Search transactions by number or customer"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200"
                        onchange="this.form.submit()" />
                </div>

                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto lg:ml-auto">
                    
                    <select name="status" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200 appearance-none bg-white bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e')] pr-10" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach(['pending','paid','cancelled','refunded'] as $st)
                            <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>

                    <select name="date" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200 appearance-none bg-white bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e')] pr-10" onchange="this.form.submit()">
                        <option value="">All Dates</option>
                        <option value="today" @selected(request('date') === 'today')>Today</option>
                        <option value="last_7_days" @selected(request('date') === 'last_7_days')>Last 7 Days</option>
                        <option value="last_30_days" @selected(request('date') === 'last_30_days')>Last 30 Days</option>
                    </select>
                    
                    <select name="payment_status" class="w-full sm:w-auto px-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200 appearance-none bg-white bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e')] pr-10" onchange="this.form.submit()">
                        <option value="">All Payments</option>
                        @foreach(['unpaid','paid','refunded', 'pending_validation'] as $pst)
                            <option value="{{ $pst }}" @selected(request('payment_status')===$pst)>{{ ucfirst(str_replace('_', ' ', $pst)) }}</option>
                        @endforeach
                    </select>

                    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 font-medium whitespace-nowrap px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 4H8l-7 16h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM12 9v6M9 12h6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Clear Filters
                    </a>

                </div>
                
                <button type="submit" class="hidden"></button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-gray-700 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-5 py-3 text-left w-10">
                                <input type="checkbox" class="rounded text-violet-600 border-gray-300 focus:ring-violet-500">
                            </th>
                            <th class="px-5 py-3 text-left whitespace-nowrap cursor-pointer hover:text-violet-600 transition-colors duration-200">Transaction ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap cursor-pointer hover:text-violet-600 transition-colors duration-200">Customer ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap cursor-pointer hover:text-violet-600 transition-colors duration-200">Status ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap cursor-pointer hover:text-violet-600 transition-colors duration-200">Total ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Payment Method</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap cursor-pointer hover:text-violet-600 transition-colors duration-200">Payment Status ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap cursor-pointer hover:text-violet-600 transition-colors duration-200">Date ↑↓</th>
                            <th class="px-5 py-3 text-center whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $o)
                        
                        <tr class="text-gray-700 hover:bg-violet-50 cursor-pointer transition-colors duration-150"
                            @click="expandedRow = expandedRow === {{ $o->id }} ? null : {{ $o->id }}">
                            <td class="px-5 py-3 w-10">
                                <input type="checkbox" class="rounded text-violet-600 border-gray-300 focus:ring-violet-500" @click.stop="">
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-900 flex items-center gap-2">
                                    <span class="text-gray-400" :class="{'rotate-90 text-violet-600': expandedRow === {{ $o->id }}}">
                                        <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                                    </span>
                                    {{ $o->order_number }}
                                </div>
                                <div class="text-xs text-gray-500 ml-6">{{ $o->orderItems->count() }} item{{ $o->orderItems->count() > 1 ? 's' : '' }}</div>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-800">{{ $o->user?->username ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ $o->user?->email ?? '—' }}</div>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                    @class([
                                            'bg-yellow-100 text-yellow-800 border border-yellow-200' => $o->status==='pending',
                                            'bg-green-100 text-green-800 border border-green-200'  => $o->status==='paid',
                                            'bg-red-100 text-red-800 border border-red-200'      => $o->status==='cancelled',
                                            'bg-gray-100 text-gray-800 border border-gray-200'    => $o->status==='refunded',
                                    ])">
                                    {{ ucfirst($o->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-bold text-gray-900 whitespace-nowrap">₱{{ number_format($o->grand_total, 2) }}</td>
                            <td class="px-5 py-3 whitespace-nowrap flex items-center gap-2">
                                @if($o->payment && $o->payment->method === 'gcash')
                                    <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path fill="#fff" d="M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm0 8a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7z"/></svg>
                                    GCash
                                @elseif($o->payment && $o->payment->method === 'cash')
                                    <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6h-1.5a3 3 0 1 0 0 6H19v4M2 6h18v12H2zm8 8v2"/></svg>
                                    Cash
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap">
                                @if($o->payment && $o->payment->method === 'gcash' && $o->payment->status === 'pending')
                                    <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-800 font-semibold border border-orange-200">
                                        Pending Validation
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full font-semibold
                                        @class([
                                                'bg-gray-100 text-gray-800 border border-gray-200'     => $o->payment_status==='unpaid',
                                                'bg-green-100 text-green-800 border border-green-200'   => $o->payment_status==='paid',
                                                'bg-yellow-100 text-yellow-800 border border-yellow-200' => $o->payment_status==='refunded',
                                                'bg-green-100 text-green-800 border border-green-200'   => $o->payment_status==='accepted',
                                        ])">
                                        {{ ucfirst($o->payment_status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-gray-600">{{ $o->created_at->format('M j, Y') }}</td>
                            <td class="px-5 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    @if($o->payment && $o->payment->method === 'gcash' && $o->payment->status === 'pending')
                                        <button type="button" 
                                                    @click.stop="
                                                            modalData = {
                                                                id: '{{ $o->payment->id ?? $o->id }}', 
                                                                order_number: '{{ $o->order_number }}',
                                                                customer: '{{ $o->user?->username ?? '—' }}',
                                                                amount: '{{ number_format($o->grand_total, 2) }}',
                                                                reference: '{{ $o->payment->provider_ref ?? 'N/A' }}',
                                                                image_url: '{{ $o->payment->receipt_image_url ?? '' }}'
                                                            };
                                                            openModal = true;
                                                    "
                                                     title="Validate GCash Payment"
                                                     class="text-amber-600 hover:text-amber-800 p-2 rounded-full hover:bg-amber-50 transition-colors duration-200">
                                                     <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15.5h2v-7h-2v7zm0-9.5h2V6h-2v2z"/></svg>
                                        </button>
                                        <a href="{{ route('admin.orders.show',$o) }}" @click.stop="" class="text-gray-500 hover:text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200" title="Manage Order Details">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.orders.show',$o) }}" @click.stop="" class="text-gray-500 hover:text-gray-800 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200" title="Manage Order Details">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                        </a>
                                        <button class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors duration-200" title="Cancel Order" @click.stop="">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr x-show="expandedRow === {{ $o->id }}" 
                            x-transition:enter="ease-out duration-300" 
                            x-transition:enter-start="opacity-0 max-h-0" 
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0"
                            class="bg-gray-50 border-b border-gray-100" style="transition: max-height 0.3s ease-in-out;">
                            <td colspan="9" class="p-5">
                                <div class="text-sm border-l-4 border-violet-500 pl-5 bg-violet-50 rounded-lg py-3 px-4">
                                    <p class="font-semibold text-violet-800 mb-2">Order Items ({{ $o->orderItems->count() }}):</p>
                                    @forelse($o->orderItems as $item)
                                        <div class="flex justify-between py-1 text-gray-700 border-b border-violet-100 last:border-b-0">
                                            <span class="truncate">{{ $item->product_name ?? 'Product Unavailable' }}</span>
                                            <span class="font-medium whitespace-nowrap">x{{ $item->quantity }}</span>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">No items found for this order.</p>
                                    @endforelse
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr><td colspan="9" class="px-5 py-6 text-center text-gray-500">No transactions found matching your criteria.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-5 border-t border-gray-100 flex justify-between items-center flex-wrap gap-3 bg-gray-50">
                <div class="text-sm text-gray-600">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </div>
                {{ $orders->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    @include('admin.partials.payment-validation-modal')
</x-admin-layout>