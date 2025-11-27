<x-app-layout>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .line-clamp-3 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        .product-image {
            width: 100%;
            height: 80px;
            object-fit: cover;
            object-position: center;
        }

        .modal-image {
            width: 100%;
            height: 320px;
            object-fit: contain;
            object-position: center;
            background: #f8fafc;
        }

        .dark .modal-image {
            background: #374151;
        }

        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    {{-- Success/Error Messages --}}
    @if (session('success'))
        <div class="fixed top-4 right-4 z-50 px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 z-50 px-6 py-3 bg-red-500 text-white rounded-lg shadow-lg animate-fade-in">
            {{ session('error') }}
        </div>
    @endif

    <div x-data="cartPage()" x-init="init()" class="py-12">
        <div class="w-full max-w-6xl px-4 sm:px-6 lg:px-8 mx-auto">

            {{-- MAIN TITLE (like screenshot) --}}
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                    Your Shopping Cart
                </h1>
                <p class="mt-2 text-sm md:text-base text-gray-500 dark:text-gray-400">
                    Review your items and proceed to checkout
                </p>
            </div>

            {{-- Top bar: item count + Continue shopping --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-semibold">Your Items ({{ $items->count() }})</span>
                </p>

                <a href="{{ route('customer.shop') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 smooth-transition shadow-sm">
                    Continue Shopping
                </a>
            </div>

            @if($items->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- CART ITEMS LIST --}}
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($items as $item)
                            @php
                                $product = $item->product;
                                if (! $product) continue;
                                $lineTotal = $item->quantity * $item->unit_price;
                            @endphp

                            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-xl smooth-transition border border-gray-100 dark:border-gray-700 px-5 py-4 flex items-start gap-4">

                                {{-- Checkbox (purely visual for now) --}}
                                <div class="pt-3">
                                    <input type="checkbox"
                                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           checked>
                                </div>

                                {{-- Image / icon block --}}
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center overflow-hidden">
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                {{-- INFO + CONTROLS --}}
                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white text-base cursor-pointer line-clamp-1"
                                                @click="openProductModal(@js($product))">
                                                {{ $product->name }}
                                            </h3>

                                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mt-1">
                                                {{ $product->description }}
                                            </p>

                                            <div class="flex flex-wrap items-center gap-2 mt-2 text-[11px] text-gray-500 dark:text-gray-400">
                                                @if($product->unit)
                                                    <span class="px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-700">
                                                        Variant: {{ $product->unit }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Remove icon (uses your toggleCart) --}}
                                        <button
                                            type="button"
                                            class="cart-btn p-2 rounded-full bg-red-50 dark:bg-red-900/40 text-red-500 hover:bg-red-100 smooth-transition"
                                            data-id="{{ $product->id }}"
                                            title="Remove from cart">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Price + quantity row (like screenshot) --}}
                                    <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Price
                                            </div>
                                            <div class="text-lg font-bold text-indigo-600">
                                                ₱{{ number_format($item->unit_price, 2) }}
                                            </div>
                                        </div>

                                        {{-- Qty controls (UI only – you can wire update later) --}}
                                        <div class="flex items-center gap-3">
                                            <button
                                                type="button"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-lg font-semibold cursor-default">
                                                –
                                            </button>
                                            <div class="min-w-[2rem] text-center text-sm font-semibold text-gray-800 dark:text-gray-100">
                                                {{ $item->quantity }}
                                            </div>
                                            <button
                                                type="button"
                                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-lg font-semibold cursor-default">
                                                +
                                            </button>
                                        </div>

                                        <div class="text-right ml-auto">
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Subtotal
                                            </div>
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                ₱{{ number_format($lineTotal, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- ORDER SUMMARY (styled like screenshot) --}}
                    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 h-fit">
                        {{-- Optional order number block – only show if passed --}}
                        @isset($cartNumber)
                            <div class="mb-6">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide text-center">
                                    Order Number
                                </div>
                                <div class="mt-2 px-4 py-3 rounded-2xl bg-amber-50 text-amber-800 text-sm font-semibold text-center">
                                    {{ $cartNumber }}
                                </div>
                            </div>
                        @endisset

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 text-center">
                            Order Summary
                        </h3>

                        <div class="mb-4">
                            <div class="flex items-center justify-between text-sm font-semibold text-gray-800 dark:text-gray-100">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 11c0-1.105.672-2 1.5-2S15 9.895 15 11s-.672 2-1.5 2S12 12.105 12 11z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 8h14l-1 11H6L5 8zM9 8V6a3 3 0 016 0v2"/>
                                    </svg>
                                    <span>Items to Checkout ({{ $items->count() }})</span>
                                </div>
                            </div>

                            {{-- scrollable list of items --}}
                            <div class="mt-3 max-h-40 overflow-y-auto no-scrollbar rounded-2xl border border-gray-100 dark:border-gray-700">
                                @foreach($items as $item)
                                    @php
                                        $product = $item->product;
                                        if (! $product) continue;
                                        $lineTotal = $item->quantity * $item->unit_price;
                                    @endphp
                                    <div class="flex items-center justify-between px-3 py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200 border-b last:border-b-0 border-gray-100 dark:border-gray-700">
                                        <div class="flex flex-col">
                                            <span class="font-medium line-clamp-1">{{ $product->name }}</span>
                                            <span class="text-[11px] text-gray-500 dark:text-gray-400">
                                                {{ $product->unit ? $product->unit.' · ' : '' }}{{ $item->quantity }}x
                                            </span>
                                        </div>
                                        <span class="font-semibold text-purple-600 dark:text-purple-400">
                                            ₱{{ number_format($lineTotal, 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

                        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300 mb-4">
                            <div class="flex justify-between">
                                <span>Items</span>
                                <span>{{ $items->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>₱{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <span class="text-base font-semibold text-gray-900 dark:text-white">Total</span>
                            <span class="text-2xl font-extrabold text-purple-600">
                                ₱{{ number_format($total, 2) }}
                            </span>
                        </div>

                        <button
                            type="button"
                            class="w-full py-3 rounded-2xl font-semibold text-white bg-purple-600 hover:bg-purple-700 smooth-transition shadow-md">
                            Checkout (placeholder)
                        </button>

                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-2">
                            Checkout functionality not implemented yet.
                        </p>
                    </div>
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h18v4H3zM3 9h18v11H3z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Your cart is empty</h3>

                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Add products from the shop and they’ll appear here.
                        </p>

                        <a href="{{ route('customer.shop') }}"
                           class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl hover:opacity-90 smooth-transition font-medium shadow-sm">
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif

        </div>

        {{-- PRODUCT MODAL (unchanged, just reused) --}}
        <div x-show="productModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">

                <div x-show="productModalOpen"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     @click="productModalOpen = false"></div>

                <div x-show="productModalOpen"
                     class="inline-block bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">

                    <template x-if="selectedProduct">
                        <div>
                            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white"
                                    x-text="selectedProduct.name"></h3>

                                <button @click="productModalOpen = false"
                                        class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                    <svg class="w-6 h-6" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="p-6">
                                <img :src="'/storage/' + selectedProduct.image_url"
                                     class="modal-image rounded-lg">

                                <div class="mt-6 space-y-4">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Description</h4>
                                        <p class="text-gray-600 dark:text-gray-400"
                                           x-text="selectedProduct.description || 'No description available'"></p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Price</h4>
                                            <p class="text-2xl font-bold text-indigo-600"
                                               x-text="'₱' + Number(selectedProduct.price).toFixed(2)"></p>
                                        </div>

                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Stock</h4>
                                            <p :class="selectedProduct.stock > 0 ? 'text-green-600' : 'text-red-600'"
                                               x-text="selectedProduct.stock > 0 ? selectedProduct.stock + ' in stock' : 'Out of stock'"></p>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Unit</h4>
                                        <p class="text-gray-600 dark:text-gray-400"
                                           x-text="selectedProduct.unit || 'N/A'"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t text-right">
                                <button
                                    type="button"
                                    @click="productModalOpen = false"
                                    class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-500 smooth-transition">
                                    Close
                                </button>
                            </div>
                        </div>
                    </template>

                </div>

            </div>
        </div>

    </div> {{-- END x-data WRAPPER --}}

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function cartPage() {
            return {
                productModalOpen: false,
                selectedProduct: null,

                inCartIds: @json($inCartIds ?? []),

                init() {
                    this.initCartButtons();
                },

                openProductModal(product) {
                    this.selectedProduct = product;
                    this.productModalOpen = true;
                },

                initCartButtons() {
                    document.addEventListener('click', (e) => {
                        const btn = e.target.closest('.cart-btn');
                        if (!btn) return;
                        this.toggleCart(btn);
                    });
                },

                toggleCart(button) {
                    const productId = button.dataset.id;
                    const originalText = button.innerHTML;

                    button.disabled = true;
                    button.innerHTML = '...';

                    fetch(`/customer/cart/toggle/${productId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json",
                        },
                    })
                        .then(async (res) => {
                            let data;
                            try {
                                data = await res.json();
                            } catch (e) {
                                data = {};
                            }

                            if (!res.ok || data.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message || 'Unable to update cart.',
                                    confirmButtonText: 'OK',
                                });
                                button.innerHTML = originalText;
                                return;
                            }

                            if (data.status === 'removed') {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Removed from cart',
                                    text: data.message || 'Product removed from cart.',
                                    confirmButtonText: 'OK',
                                });
                                window.location.reload();
                            } else if (data.status === 'added') {
                                // Not expected on cart page, but just in case
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Added to cart',
                                    text: data.message || 'Product added to cart.',
                                    confirmButtonText: 'OK',
                                });
                                window.location.reload();
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to update cart.',
                                confirmButtonText: 'OK',
                            });
                            button.innerHTML = originalText;
                        })
                        .finally(() => {
                            button.disabled = false;
                        });
                },
            }
        }
    </script>
</x-app-layout>
