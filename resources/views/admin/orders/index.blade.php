<x-admin-layout>
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div x-data="{
        openModal: false,
        modalData: {},
        expandedRow: null,

        // Function to handle cancel confirmation
        confirmCancel(cancelUrl, orderNumber) {
            Swal.fire({
                title: 'Confirm Cancellation',
                text: 'Are you sure you want to cancel order ' + orderNumber + '? This action cannot be reversed.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Red
                cancelButtonColor: '#6b7280', // Gray
                confirmButtonText: 'Yes, Cancel It!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = cancelUrl;

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    }" class="min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Transactions Overview</h1>

            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('admin.orders.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 text-white text-base font-semibold rounded-xl shadow-lg hover:bg-violet-700 hover:shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                    </svg>
                    New Transaction
                </a>
            </div>
        </div>

        {{-- KPI CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-blue-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalOrders ?? 0) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-orange-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10zM12 8v4M12 16h.01"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Validation</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($pendingValidationCount ?? 0) }}</p>
                    <p class="text-xs font-medium text-orange-600 mt-0.5">GCash payments need review</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-emerald-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 1v22M17 5H7M17 19H7M19 9h-2M5 9h2M19 15h-2M5 15h2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">₱{{ number_format($monthlyRevenue ?? 0, 2) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-violet-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-violet-100 text-violet-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M10 2H2v8l9 9 9-9-8-8zM15 3h6v6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Ready for Pickup</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($readyForPickupCount ?? 0) }}</p>
                </div>
            </div>
        </div>

        {{-- FILTERS + TABLE WRAPPER --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            {{-- FILTERS --}}
            <form method="get" class="p-5 bg-gray-50 flex flex-col lg:flex-row items-center lg:items-stretch gap-4 border-b border-gray-100">
                <div class="relative w-full lg:w-80">
                    <svg class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 19l-6-6M5 11a6 6 0 1 1 12 0 6 6 0 0 1-12 0z"/>
                    </svg>
                    <input name="s"
                           value="{{ request('s') }}"
                           placeholder="Search transactions by number or customer"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200"
                           onchange="this.form.submit()" />
                </div>

                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto lg:ml-auto">
                    <select name="status"
                            class="w-full sm:w-auto px-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200 appearance-none bg-white bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e')] pr-10"
                            onchange="this.form.submit()">
                        <option value="">All Status</option>
                        @foreach(['pending','paid','cancelled','refunded'] as $st)
                            <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>

                    <select name="date"
                            class="w-full sm:w-auto px-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200 appearance-none bg-white bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e')] pr-10"
                            onchange="this.form.submit()">
                        <option value="">All Dates</option>
                        <option value="today" @selected(request('date') === 'today')>Today</option>
                        <option value="last_7_days" @selected(request('date') === 'last_7_days')>Last 7 Days</option>
                        <option value="last_30_days" @selected(request('date') === 'last_30_days')>Last 30 Days</option>
                    </select>

                    <select name="payment_status"
                            class="w-full sm:w-auto px-4 py-2.5 rounded-xl border-gray-300 focus:ring-violet-500 focus:border-violet-500 text-sm shadow-sm transition-all duration-200 appearance-none bg-white bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 16 16\'%3e%3cpath fill=\'none\' stroke=\'%23334155\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'m2 5 6 6 6-6\'/%3e%3c/svg%3e')] pr-10"
                            onchange="this.form.submit()">
                        <option value="">All Payments</option>
                        @foreach(['unpaid','paid','refunded'] as $pst)
                            <option value="{{ $pst }}" @selected(request('payment_status')===$pst)>
                                {{ ucfirst(str_replace('_', ' ', $pst)) }}
                            </option>
                        @endforeach
                    </select>

                    <a href="{{ route('admin.orders.index') }}"
                       class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 font-medium whitespace-nowrap px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 4H8l-7 16h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM12 9v6M9 12h6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Clear Filters
                    </a>
                </div>

                <button type="submit" class="hidden"></button>
            </form>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-gray-700 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-5 py-3 text-left w-10">
                                <input type="checkbox" class="rounded text-violet-600 border-gray-300 focus:ring-violet-500">
                            </th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Transaction ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Customer ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Status ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Total ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Payment Method</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Payment Status ↑↓</th>
                            <th class="px-5 py-3 text-left whitespace-nowrap">Date ↑↓</th>
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
                                        <span class="text-gray-400"
                                              :class="{'rotate-90 text-violet-600': expandedRow === {{ $o->id }}}">
                                            <svg class="h-4 w-4 transition-transform duration-200"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M9 18l6-6-6-6"/>
                                            </svg>
                                        </span>
                                        {{ $o->order_number }}
                                    </div>
                                    <div class="text-xs text-gray-500 ml-6">
                                        {{ $o->items->count() }} item{{ $o->items->count() > 1 ? 's' : '' }}
                                    </div>
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-gray-800">{{ ($o->user?->fname ?? '') . ' ' . ($o->user?->lname ?? '') ?: '—' }}</div>
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap">
                                    <span
                                        @class([
                                            'bg-yellow-100 text-yellow-800 border border-yellow-200 px-3 py-1 text-xs rounded-full font-semibold' => $o->status === 'Pending',
                                            'bg-green-100 text-green-800 border border-green-200 px-3 py-1 text-xs rounded-full font-semibold'    => $o->status === 'Completed',
                                        ])">
                                        {{ ucfirst($o->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 font-bold text-gray-900 whitespace-nowrap">
                                    ₱{{ number_format((float)$o->grand_total, 2) }}
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap flex items-center gap-2">
                                    @if($o->payment?->method === 'gcash')
                                        <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                            <circle cx="12" cy="12" r="10"/>
                                            <path fill="#fff" d="M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm0 8a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7z"/>
                                        </svg>
                                        GCash
                                    @elseif($o->payment?->method === 'cash')
                                        <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                            <path d="M18 6h-1.5a3 3 0 1 0 0 6H19v4M2 6h18v12H2zm8 8v2"/>
                                        </svg>
                                        Cash
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap">

                                        <span
                                            @class([
                                                'bg-gray-100 text-gray-800 border border-gray-200 px-3 py-1 text-xs rounded-full font-semibold'   => $o->payment_status === 'Unpaid',
                                                'bg-yellow-100 text-yellow-800 border border-yellow-200 px-3 py-1 text-xs rounded-full font-semibold' => $o->payment_status === 'For Verification',
                                                'bg-green-100 text-green-800 border border-green-200 px-3 py-1 text-xs rounded-full font-semibold' => $o->payment_status === 'Paid',
                                            ])">
                                            {{ ucfirst($o->payment_status) }}
                                        </span>
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-gray-600">
                                    {{ optional($o->created_at)->format('M j, Y') }}
                                </td>
                                <td class="px-5 py-3 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($o->payment?->method === 'gcash' && $o->payment_status === 'For Verification')
                                            <button
                                                type="button"
                                                @click="modalData = {
                                                    id: {{ $o->id }},
                                                    order_number: '{{ $o->order_number }}',
                                                    customer: '{{ ($o->user?->fname ?? '') . ' ' . ($o->user?->lname ?? '') }}',
                                                    email: '{{ $o->user?->email ?? '' }}',
                                                    amount: '{{ number_format((float)$o->grand_total, 2) }}',
                                                    method: '{{ $o->payment?->method }}',
                                                    reference: '{{ $o->payment?->provider_ref ?? '' }}',
                                                    image_url: '{{ $o->payment?->receipt_image_url ? asset(ltrim($o->payment->receipt_image_url, '/')) : '' }}',
                                                    date: '{{ optional($o->created_at)->format('M j, Y g:i A') }}',
                                                    items_count: {{ $o->items->count() }},
                                                    status: '{{ $o->status }}',
                                                    payment_status: '{{ $o->payment_status }}'
                                                }; openModal = true"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition"
                                            >
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Verify GCash
                                            </button>
                                        @elseif($o->payment_status !== 'Paid')
                                            @if($o->payment?->method === 'cash')
                                                <form method="POST" action="{{ route('admin.orders.markPaidCash', $o) }}">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition">
                                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                        Mark Paid
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif($o->status !== 'Completed' && $o->status !== 'completed')
                                            <form method="POST" action="{{ route('admin.orders.update', ['order' => $o]) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Completed">
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-white bg-violet-600 hover:bg-violet-700 shadow-sm transition">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    Complete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-medium">Done</span>
                                        @endif

                                        @if($o->status !== 'cancelled' && $o->status !== 'Completed' && $o->status !== 'completed')
                                            <button type="button"
                                                @click="confirmCancel('{{ route('admin.orders.cancel', $o) }}', '{{ $o->order_number }}')"
                                                class="inline-flex items-center gap-1 px-2.5 py-2 rounded-xl text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition">
                                                Cancel
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- EXPANDED ROW --}}
                            <tr x-show="expandedRow === {{ $o->id }}"
                                x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-screen"
                                x-transition:leave="ease-in duration-200"
                                x-transition:leave-start="opacity-100 max-h-screen"
                                x-transition:leave-end="opacity-0 max-h-0"
                                class="bg-gray-50 border-b border-gray-100"
                                style="transition: max-height 0.3s ease-in-out;">
                                <td colspan="9" class="p-5">
                                    <div class="text-sm border-l-4 border-violet-500 pl-5 bg-violet-500/10 rounded-lg py-3 px-4">
                                        <p class="font-semibold text-violet-800 mb-2">
                                            Order Items ({{ $o->items->count() }}):
                                        </p>
                                        @forelse($o->items as $item)
                                            <div class="flex justify-between py-1 text-gray-700 border-b border-violet-100 last:border-b-0">
                                                <span class="truncate">
                                                    {{ $item->product->name ?? 'Product Unavailable' }}
                                                </span>
                                                <span class="font-medium whitespace-nowrap">
                                                    x{{ (int)$item->quantity }}
                                                </span>
                                            </div>
                                        @empty
                                            <p class="text-gray-500">No items found for this order.</p>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-6 text-center text-gray-500">
                                    No transactions found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="p-5 border-t border-gray-100 flex justify-between items-center flex-wrap gap-3 bg-gray-50">
                <div class="text-sm text-gray-600">
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                </div>
                {{ $orders->links('pagination::tailwind') }}
            </div>
        </div>

        {{-- GCash VALIDATION MODAL --}}
        <div
            x-show="openModal"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div
                @click.away="openModal = false"
                class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden max-h-[90vh] flex flex-col"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            >
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-blue-50 to-violet-50 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-sm">
                            <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Verify GCash Payment</h3>
                            <p class="text-xs text-gray-500">Order <span class="font-bold text-blue-600" x-text="modalData.order_number"></span></p>
                        </div>
                    </div>
                    <button type="button" @click="openModal = false" class="p-2 rounded-full hover:bg-white/80 text-gray-400 hover:text-gray-700 transition">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-5 space-y-5 overflow-y-auto flex-1">
                    {{-- Order Info Cards --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Customer</p>
                            <p class="text-sm font-bold text-gray-900 mt-1 truncate" x-text="modalData.customer"></p>
                            <p class="text-[11px] text-gray-500 truncate" x-text="modalData.email"></p>
                        </div>
                        <div class="bg-emerald-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] uppercase tracking-wider text-emerald-500 font-semibold">Amount</p>
                            <p class="text-xl font-black text-emerald-600 mt-1">₱<span x-text="modalData.amount"></span></p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] uppercase tracking-wider text-blue-400 font-semibold">Method</p>
                            <p class="text-sm font-bold text-blue-700 mt-1">GCash</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Date</p>
                            <p class="text-sm font-semibold text-gray-700 mt-1" x-text="modalData.date"></p>
                        </div>
                    </div>

                    {{-- Reference --}}
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-1">GCash Reference Number</p>
                        <p class="text-base font-mono font-bold text-gray-900" x-text="modalData.reference || 'Not provided'"></p>
                    </div>

                    {{-- Receipt Image --}}
                    <template x-if="modalData.image_url">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-2">Payment Receipt</p>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl overflow-hidden bg-gray-50 relative group">
                                <img
                                    class="w-full max-h-[400px] object-contain"
                                    :src="modalData.image_url"
                                    alt="GCash Receipt"
                                >
                                <a :href="modalData.image_url" target="_blank"
                                   class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-white shadow-sm border transition opacity-0 group-hover:opacity-100">
                                    <svg class="h-3.5 w-3.5 inline mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M10 14L21 3M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Open Full Size
                                </a>
                            </div>
                        </div>
                    </template>

                    <template x-if="!modalData.image_url">
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center bg-gray-50">
                            <svg class="h-10 w-10 text-gray-300 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <p class="text-sm text-gray-400 font-medium">No receipt image uploaded</p>
                        </div>
                    </template>

                    {{-- Warning --}}
                    <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 text-xs text-amber-800 flex gap-2.5">
                        <svg class="h-4 w-4 mt-0.5 flex-shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 9v4m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0z" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p>Verify that the <strong>amount</strong> and <strong>reference number</strong> on the receipt match your GCash records before accepting. Reject if the proof is invalid, unclear, or doesn't match.</p>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center gap-3 shrink-0">
                    <button type="button" @click="openModal = false"
                        class="px-4 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 border border-gray-200 hover:bg-white transition">
                        Close
                    </button>

                    <div class="flex items-center gap-2">
                        <form method="POST" :action="`{{ url('admin/orders') }}/${modalData.id}/reject-payment`">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition"
                                onclick="return confirm('Reject this GCash payment?')">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Reject Payment
                            </button>
                        </form>

                        <form method="POST" :action="`{{ url('admin/orders') }}/${modalData.id}/accept-payment`">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md hover:shadow-lg transition"
                                onclick="return confirm('Accept this payment and mark order as paid?')">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Accept & Mark Paid
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div> {{-- end x-data wrapper --}}

    {{-- SWEETALERT FLASH MESSAGE HANDLING --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('ok') || session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('ok') ?? session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                });
            @endif
        });
    </script>
</x-admin-layout>
