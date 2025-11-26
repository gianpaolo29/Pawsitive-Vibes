<x-admin-layout>
    <div 
        x-data="{ expandedRow: null }"
        class="min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8"
    >

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900">Completed Orders</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-5 py-3 text-left">Transaction</th>
                            <th class="px-5 py-3 text-left">Customer</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Total</th>
                            <th class="px-5 py-3 text-left">Payment</th>
                            <th class="px-5 py-3 text-left">Date</th>
                            <th class="px-5 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $o)
                        <tr class="hover:bg-violet-50 cursor-pointer"
                            @click="expandedRow = expandedRow === {{ $o->id }} ? null : {{ $o->id }}">

                            <td class="px-5 py-3 font-medium">{{ $o->order_number }}</td>

                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $o->user?->username ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ $o->user?->email }}</div>
                            </td>

                            <td class="px-5 py-3">
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Completed
                                </span>
                            </td>

                            <td class="px-5 py-3 font-bold">
                                ₱{{ number_format($o->grand_total, 2) }}
                            </td>

                            <td class="px-5 py-3">
                                @if($o->payment?->method === 'gcash')
                                    <span class="text-blue-600 font-medium">GCash</span>
                                @else
                                    <span class="text-emerald-600 font-medium">Cash</span>
                                @endif
                            </td>

                            <td class="px-5 py-3 text-gray-600">
                                {{ $o->created_at->format('M j, Y') }}
                            </td>

                            <td class="px-5 py-3 text-center">
                                <a href="{{ route('admin.orders.show', $o) }}"
                                   class="text-gray-600 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </a>
                            </td>
                        </tr>

                        <tr x-show="expandedRow === {{ $o->id }}" 
                            x-transition 
                            class="bg-gray-50">
                            <td colspan="7" class="p-5">
                                <div class="text-sm border-l-4 border-emerald-500 pl-5 bg-emerald-50 rounded-lg py-3 px-4">
                                    <p class="font-semibold text-emerald-800 mb-2">Order Items:</p>
                                    @foreach($o->items as $item)
                                        <div class="flex justify-between py-1">
                                            <span>{{ $item->product_name }}</span>
                                            <span>x{{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-5 text-center text-gray-500">No completed orders found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t bg-gray-50">
                {{ $orders->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</x-admin-layout>
