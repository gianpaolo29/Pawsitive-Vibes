<x-app-layout>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-bg { background: #ffffff; }
        .dark .card-bg { background: #1f2937; }
    </style>

    @php
        $payment = $transaction->payments->first();
        $formattedId = '#'.str_pad($transaction->id, 6, '0', STR_PAD_LEFT);
    @endphp

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header / Thank You --}}
            <div class="card-bg rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-8 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-extrabold gradient-text">
                                Thank you for your order!
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Your order has been placed successfully.
                            </p>
                        </div>
                    </div>
                    <div class="text-right text-sm">
                        <div class="font-semibold text-gray-900 dark:text-white">
                            Order {{ $formattedId }}
                        </div>
                        <div class="text-gray-500 dark:text-gray-400">
                            {{ $transaction->created_at?->format('M d, Y h:i A') }}
                        </div>
                    </div>
                </div>

                {{-- Status badge --}}
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                        Status: {{ ucfirst($transaction->status) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left: items --}}
                <div class="lg:col-span-2 space-y-4">
                    <div class="card-bg rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                            Order Items
                        </h2>

                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($transaction->items as $item)
                                @php
                                    $product = $item->product;
                                    $unitLabel = $product?->unit ?? ($product?->category?->name ?? 'Item');
                                @endphp
                                <div class="py-3 flex items-center gap-4">
                                    {{-- Image --}}
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                                            @if($product && $product->image_url)
                                                <img src="{{ asset('storage/' . $product->image_url) }}"
                                                     alt="{{ $product->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0">
                                                <p class="font-semibold text-gray-900 dark:text-white line-clamp-1">
                                                    {{ $product->name ?? 'Product #'.$item->product_id }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                    {{ $unitLabel }} &middot; Qty: {{ $item->quantity }}
                                                </p>
                                            </div>
                                            <div class="text-right text-sm">
                                                <div class="text-gray-500 dark:text-gray-400">
                                                    ₱{{ number_format($item->unit_price, 2) }}
                                                </div>
                                                <div class="font-semibold text-gray-900 dark:text-white">
                                                    ₱{{ number_format($item->line_total, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right: payment + totals --}}
                <div class="space-y-4">
                    <div class="card-bg rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                            Payment Details
                        </h2>

                        @if($payment)
                            <dl class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <dt class="text-gray-500 dark:text-gray-400">Method</dt>
                                    <dd class="font-semibold text-gray-900 dark:text-white uppercase">
                                        {{ $payment->method === 'gcash' ? 'GCash' : 'Cash' }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500 dark:text-gray-400">Amount</dt>
                                    <dd class="font-semibold text-gray-900 dark:text-white">
                                        ₱{{ number_format($payment->amount, 2) }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-gray-500 dark:text-gray-400">Payment Status</dt>
                                    <dd>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                     {{ $payment->status === 'pending' || $payment->status === 'pending_verification'
                                                         ? 'bg-yellow-50 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-200'
                                                         : 'bg-green-50 text-green-700 dark:bg-green-900/40 dark:text-green-200' }}">
                                            {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                        </span>
                                    </dd>
                                </div>

                                @if($payment->method === 'gcash' && $payment->receipt_image_url)
                                    <div class="pt-2 border-t border-gray-100 dark:border-gray-700 mt-2">
                                        <dt class="text-gray-500 dark:text-gray-400 mb-2">GCash Receipt</dt>
                                        <dd>
                                            <a href="{{ asset('storage/' . $payment->receipt_image_url) }}"
                                               target="_blank"
                                               class="inline-flex items-center text-xs font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
                                                View uploaded receipt
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                No payment record found for this order.
                            </p>
                        @endif
                    </div>

                    <div class="card-bg rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                            Order Summary
                        </h2>

                        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300 mb-4">
                            <div class="flex justify-between">
                                <span>Items Total</span>
                                <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span class="text-green-600">FREE</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Taxes</span>
                                <span>₱0.00</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-base font-semibold text-gray-900 dark:text-white">
                                Grand Total
                            </span>
                            <span class="text-2xl font-extrabold gradient-text">
                                ₱{{ number_format($transaction->total_amount, 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('customer.shop') }}"
                           class="inline-flex items-center justify-center px-4 py-3 rounded-2xl text-sm font-semibold
                                  bg-indigo-600 text-white hover:bg-indigo-700 smooth-transition shadow-md">
                            Continue Shopping
                        </a>
                        <a href="{{ route('customer.cart.index') }}"
                           class="inline-flex items-center justify-center px-4 py-2 rounded-2xl text-xs font-medium
                                  border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
