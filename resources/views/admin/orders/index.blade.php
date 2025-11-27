<x-admin-layout>
    {{-- SweetAlert2 CDN (Include this in your <head> or layout file if not already global) --}}
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
                    // Create a temporary form to submit the PATCH request (or whatever method your route uses)
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = cancelUrl;
                    
                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    // Add PATCH method spoofing for Laravel
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PATCH'; 
                    form.appendChild(methodInput); // Assuming your cancel route uses PATCH

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
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14" stroke-linecap="round"/></svg>
                    New Transaction
                </a>
            </div>
        </div>

        {{-- Removed the old session('ok') alert box --}}
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-blue-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalOrders ?? 0) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-orange-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10zM12 8v4M12 16h.01"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Validation</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($pendingValidationCount ?? 0) }}</p>
                    <p class="text-xs font-medium text-orange-600 mt-0.5">GCash payments need review</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-emerald-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 1v22M17 5H7M17 19H7M19 9h-2M5 9h2M19 15h-2M5 15h2"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">₱{{ number_format($monthlyRevenue ?? 0, 2) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-5 flex items-center gap-4 border-b-4 border-violet-500 hover:shadow-xl">
                <div class="p-3 rounded-full bg-violet-100 text-violet-600 flex-shrink-0">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 2H2v8l9 9 9-9-8-8zM15 3h6v6"/></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Ready for Pickup</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($readyForPickupCount ?? 0) }}</p>
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
                        @foreach(['unpaid','paid','refunded'] as $pst)
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
                                        <span class="text-gray-400" :class="{'rotate-90 text-violet-600': expandedRow === {{ $o->id }}}">
                                            <svg class="h-4 w-4 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                                        </span>
                                        {{ $o->order_number }}
                                    </div>
                                    <div class="text-xs text-gray-500 ml-6">{{ $o->items->count() }} item{{ $o->items->count() > 1 ? 's' : '' }}</div>
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
                                            'bg-red-100 text-red-800 border border-red-200'        => $o->status==='cancelled',
                                            'bg-gray-100 text-gray-800 border border-gray-200'      => $o->status==='refunded',
                                        ])">
                                            {{ ucfirst($o->status) }}
                                        </span>
                                </td>
                                <td class="px-5 py-3 font-bold text-gray-900 whitespace-nowrap">₱{{ number_format((float)$o->grand_total, 2) }}</td>
                                <td class="px-5 py-3 whitespace-nowrap flex items-center gap-2">
                                    @if($o->payment?->method === 'gcash')
                                        <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path fill="#fff" d="M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm0 8a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7z"/></svg>
                                        GCash
                                    @elseif($o->payment?->method === 'cash')
                                        <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6h-1.5a3 3 0 1 0 0 6H19v4M2 6h18v12H2zm8 8v2"/></svg>
                                        Cash
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap">
                                    @if($o->payment?->method === 'gcash' && $o->payment?->status === 'pending')
                                        <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-800 font-semibold border border-orange-200">Pending Validation</span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                                            @class([
                                                'bg-gray-100 text-gray-800 border border-gray-200'   => $o->payment_status==='unpaid',
                                                'bg-green-100 text-green-800 border border-green-200' => $o->payment_status==='paid',
                                                'bg-yellow-100 text-yellow-800 border border-yellow-200' => $o->payment_status==='refunded',
                                            ])">
                                                {{ ucfirst($o->payment_status) }}
                                            </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-gray-600">{{ optional($o->created_at)->format('M j, Y') }}</td>
                                <td class="px-5 py-3 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-2">
                                        {{-- Wire your own show/cancel routes here when ready; buttons are non-breaking --}}
                                        @if($o->payment?->method === 'gcash' && $o->payment?->status === 'pending')
                                            <button type="button"
                                                @click.stop="
                                                    modalData = {
                                                         id: '{{ $o->payment?->id ?? $o->id }}',
                                                         order_number: '{{ $o->order_number }}',
                                                         customer: '{{ $o->user?->username ?? '—' }}',
                                                         amount: '{{ number_format((float)$o->grand_total, 2) }}',
                                                         reference: '{{ $o->payment?->provider_ref ?? 'N/A' }}',
                                                         image_url: '{{ $o->payment?->receipt_image_url ?? '' }}'
                                                     };
                                                     openModal = true;
                                                "
                                                title="Validate GCash Payment"
                                                class="text-amber-600 hover:text-amber-800 p-2 rounded-full hover:bg-amber-50">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm-1 15.5h2v-7h-2v7zm0-9.5h2V6h-2v2z"/></svg>
                                            </button>
                                        @endif

                                        <button class="text-gray-500 hover:text-gray-800 p-2 rounded-full hover:bg-gray-100" title="Manage Order" @click.stop="">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                        </button>

                                        {{-- MODIFIED: Added SweetAlert for Cancel confirmation --}}
                                        <button type="button" 
                                            @click.stop="confirmCancel('{{ route('admin.orders.cancel', $o) }}', '{{ $o->order_number }}')" 
                                            class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                            title="Cancel Order">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                        </button>
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
                                        <p class="font-semibold text-violet-800 mb-2">Order Items ({{ $o->items->count() }}):</p>
                                        @forelse($o->items as $item)
                                            <div class="flex justify-between py-1 text-gray-700 border-b border-violet-100 last:border-b-0">
                                                <span class="truncate">{{ $item->product->name ?? 'Product Unavailable' }}</span>
                                                <span class="font-medium whitespace-nowrap">x{{ (int)$item->quantity }}</span>
                                            </div>
                                        @empty
                                            <p class="text-gray-500">No items found for this order.</p>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-6 text-center text-gray-500">No transactions found matching your criteria.</td>
                            </tr>
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

    {{-- SWEETALERT FLASH MESSAGE HANDLING --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check for Laravel session flash messages: 'ok', 'success', or 'error'
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