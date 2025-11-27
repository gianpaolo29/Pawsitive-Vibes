<x-app-layout>
    <style>
        /* --- UTILITIES & BASE --- */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

        .product-image-list { width: 64px; height: 64px; object-fit: cover; }

        .modal-image { width: 100%; height: 320px; object-fit: contain; background: #f8fafc; }
        .dark .modal-image { background: #374151; }

        .smooth-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .gradient-bg { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); } /* Indigo theme */

        .cart-card-bg { background: #ffffff; }
        .dark .cart-card-bg { background: #1f2937; }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
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

    <div x-data="cartPage()" class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        {{-- container-fluid style --}}
        <div class="w-full max-w-full px-4 sm:px-6 lg:px-8 mx-auto">

            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">
                    Your Shopping Cart 🛒
                </h2>
                <p class="mt-2 text-sm md:text-base text-gray-500 dark:text-gray-400">
                    Review your items and proceed to checkout
                </p>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-semibold text-lg">{{ $items->count() }} Items</span> in your cart
                </p>
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
                                $maxStock  = $product->stock ?? 999999;
                                $unitLabel = $product->unit ?? ($product->category->name ?? 'Item');
                            @endphp

                            <div class="cart-card-bg rounded-3xl shadow-lg smooth-transition border border-gray-200 dark:border-gray-700 p-4 sm:p-5 flex items-start gap-4">

                                {{-- Image --}}
                                <div class="flex-shrink-0 pt-1">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border border-gray-200 dark:border-gray-600">
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}"
                                                 alt="{{ $product->name }}"
                                                 class="product-image-list">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                {{-- INFO + CONTROLS --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        {{-- Title & unit --}}
                                        <div class="min-w-0">
                                            <h3 class="font-bold text-gray-900 dark:text-white text-lg cursor-pointer line-clamp-1"
                                                @click="openProductModal(@js($product))">
                                                {{ $product->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1 mt-1">
                                                {{ $unitLabel }}
                                            </p>
                                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                Stock: {{ $maxStock }}
                                            </p>
                                        </div>

                                        {{-- Remove --}}
                                        <form action="{{ route('customer.cart.destroy', $item->id) }}" method="POST" class="flex-shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-full bg-red-50 dark:bg-red-900/40 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/80 smooth-transition"
                                                title="Remove from cart">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- qty + subtotal + checkbox --}}
                                    <div class="mt-4 flex flex-wrap items-center gap-4 border-t pt-3 border-gray-100 dark:border-gray-700">

                                        {{-- Quantity controls (editable, max = stock) --}}
                                        <div class="flex items-center gap-2">
                                            <button type="button"
                                                class="qty-minus w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-lg font-semibold hover:bg-gray-200"
                                                data-item-id="{{ $item->id }}">
                                                –
                                            </button>

                                            <input
                                                type="number"
                                                class="qty-input min-w-[3rem] text-center text-sm font-bold text-gray-800 dark:text-gray-100 px-2 py-1 rounded-lg border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                                max="{{ $maxStock }}"
                                                data-item-id="{{ $item->id }}"
                                                data-price="{{ $item->unit_price }}"
                                                data-name="{{ $product->name }}"
                                                data-unit="{{ $unitLabel }}"
                                            >

                                            <button type="button"
                                                class="qty-plus w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 text-lg font-semibold hover:bg-gray-200"
                                                data-item-id="{{ $item->id }}">
                                                +
                                            </button>
                                        </div>

                                        {{-- Subtotal + checkbox to include in summary --}}
                                        <div class="flex items-center gap-3 ml-auto">
                                            <div class="text-right">
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Subtotal</div>
                                                <div
                                                    class="text-xl font-extrabold text-gray-900 dark:text-white"
                                                    data-line-subtotal
                                                    data-item-id="{{ $item->id }}"
                                                >
                                                    ₱{{ number_format($lineTotal, 2) }}
                                                </div>
                                            </div>

                                            <div class="flex items-center">
                                                <input
                                                    type="checkbox"
                                                    class="summary-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                    data-item-id="{{ $item->id }}"
                                                    checked
                                                    title="Include in summary"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- ORDER SUMMARY / CHECKOUT FORM --}}
                    <form
                        id="checkout-form" {{-- ADDED ID HERE --}}
                        method="POST"
                        action="{{ route('customer.cart.checkout') }}"
                        enctype="multipart/form-data"
                        class="cart-card-bg rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 h-fit sticky top-8"
                        x-data="{ paymentMethod: 'cash' }"
                    >
                        @csrf

                        {{-- HIDDEN FIELDS: one set per cart item so backend gets all data --}}
                        @foreach($items as $item)
                            @php
                                $product = $item->product;
                                if (! $product) continue;
                            @endphp

                            <input
                                type="hidden"
                                name="items[{{ $item->id }}][cart_item_id]"
                                value="{{ $item->id }}"
                                data-hidden-item-id="{{ $item->id }}"
                            >

                            <input
                                type="hidden"
                                name="items[{{ $item->id }}][product_id]"
                                value="{{ $product->id }}"
                            >

                            <input
                                type="hidden"
                                name="items[{{ $item->id }}][qty]"
                                value="{{ $item->quantity }}"
                                data-hidden-qty="{{ $item->id }}"
                            >

                            <input
                                type="hidden"
                                name="items[{{ $item->id }}][selected]"
                                value="1"
                                data-hidden-selected="{{ $item->id }}"
                            >

                            <input
                                type="hidden"
                                name="items[{{ $item->id }}][price]"
                                value="{{ $item->unit_price }}"
                            >
                        @endforeach

                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center border-b pb-4">
                            Order Summary
                        </h3>

                        {{-- dynamic summary rows --}}
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300 mb-6">
                            <div class="flex justify-between">
                                <span class="font-medium">
                                    Subtotal (<span id="summary-items-count">{{ $items->sum('quantity') }}</span> items)
                                </span>
                                <span id="summary-subtotal">
                                    ₱{{ number_format($total, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Shipping (Placeholder)</span>
                                <span class="text-green-600">FREE</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-medium">Taxes (Placeholder)</span>
                                <span>₱0.00</span>
                            </div>
                        </div>

                        {{-- items list for summary (will be rebuilt by JS) --}}
                        <div class="mb-6">
                            <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                                Items to Checkout
                            </div>
                            <div id="summary-items-list" class="mt-1 max-h-40 overflow-y-auto no-scrollbar rounded-2xl border border-gray-100 dark:border-gray-700">
                                @foreach($items as $item)
                                    @php
                                        $product = $item->product;
                                        if (! $product) continue;
                                        $lineTotal = $item->quantity * $item->unit_price;
                                        $unitLabel = $product->unit ?? ($product->category->name ?? 'Item');
                                    @endphp
                                    <div class="flex items-center justify-between px-3 py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200 border-b last:border-b-0 border-gray-100 dark:border-gray-700">
                                        <div class="flex flex-col">
                                            <span class="font-medium line-clamp-1">{{ $product->name }}</span>
                                            <span class="text-[11px] text-gray-500 dark:text-gray-400">
                                                {{ $unitLabel ? $unitLabel.' · ' : '' }}{{ $item->quantity }}x
                                            </span>
                                        </div>
                                        <span class="font-semibold text-purple-600 dark:text-purple-400">
                                            ₱{{ number_format($lineTotal, 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- PAYMENT METHOD --}}
                        <div class="mb-6 space-y-3">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                Payment Method
                            </h4>

                            {{-- CASH --}}
                            <label class="flex items-center gap-3 px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="cash"
                                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    x-model="paymentMethod"
                                    required
                                >
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Cash / COD</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Pay in cash upon pickup or delivery.
                                    </span>
                                </div>
                            </label>

                            {{-- GCASH --}}
                            <label class="flex items-center gap-3 px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                                <input
                                    type="radio"
                                    name="payment_method"
                                    value="gcash"
                                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    x-model="paymentMethod"
                                    required
                                >
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">GCash</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Send payment via GCash and upload your receipt.
                                    </span>
                                </div>
                            </label>

                                {{-- GCash receipt upload – only when gcash --}}
                                <div x-show="paymentMethod === 'gcash'" x-cloak class="mt-3 space-y-1">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                        Upload GCash Receipt
                                    </label>
                                    <input
                                        type="file"
                                        name="receipt_image"
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-900 dark:text-gray-100
                                            border border-gray-300 dark:border-gray-600 rounded-lg
                                            cursor-pointer bg-gray-50 dark:bg-gray-800
                                            focus:outline-none focus:ring-1 focus:ring-indigo-500"
                                    >
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Upload a clear screenshot of your GCash payment.
                                    </p>
                                </div>
                            </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700 mb-6">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Order Total</span>
                            <span class="text-3xl font-extrabold gradient-text" id="summary-total">
                                ₱{{ number_format($total, 2) }}
                            </span>
                        </div>

                        {{-- MODIFIED SUBMIT BUTTON --}}
                        <button
                            type="button" {{-- CHANGED TO TYPE="BUTTON" --}}
                            id="checkout-button" {{-- ADDED ID HERE --}}
                            class="w-full py-3 rounded-2xl font-semibold text-white gradient-bg hover:opacity-90 smooth-transition shadow-lg">
                            Proceed to Checkout
                        </button>

                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-3">
                            Taxes and shipping calculated at checkout.
                        </p>
                    </form>
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div class="text-center py-20 cart-card-bg rounded-3xl shadow-lg border border-gray-200 dark:border-gray-700">
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

        {{-- PRODUCT MODAL --}}
        <div x-show="productModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                <div x-show="productModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="productModalOpen = false"></div>
                <div x-show="productModalOpen" class="inline-block cart-card-bg rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <template x-if="selectedProduct">
                        <div>
                            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="selectedProduct.name"></h3>
                                <button @click="productModalOpen = false" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                    <svg class="w-6 h-6" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6">
                                <img :src="'/storage/' + selectedProduct.image_url" class="modal-image rounded-lg">
                                <div class="mt-6 space-y-4">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Description</h4>
                                        <p class="text-gray-600 dark:text-gray-400" x-text="selectedProduct.description || 'No description available'"></p>
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
                                        <p class="text-gray-600 dark:text-gray-400" x-text="selectedProduct.unit || 'N/A'"></p>
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

                openProductModal(product) {
                    this.selectedProduct = product;
                    this.productModalOpen = true;
                },
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const qtyInputs    = document.querySelectorAll('.qty-input');
            const minusBtns    = document.querySelectorAll('.qty-minus');
            const plusBtns     = document.querySelectorAll('.qty-plus');
            const checkboxes   = document.querySelectorAll('.summary-checkbox');
            const checkoutButton = document.getElementById('checkout-button'); // GET CHECKOUT BUTTON
            const checkoutForm   = document.getElementById('checkout-form');   // GET CHECKOUT FORM

            function formatCurrency(amount) {
                amount = Number(amount) || 0;
                return '₱' + amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            function recalcSummary() {
                let totalItems = 0;
                let subtotal   = 0;

                const summaryList = document.getElementById('summary-items-list');
                if (summaryList) summaryList.innerHTML = '';

                checkboxes.forEach(cb => {
                    const itemId = cb.dataset.itemId;
                    const input  = document.querySelector('.qty-input[data-item-id="'+itemId+'"]');
                    if (!input) return;

                    const price = parseFloat(input.dataset.price || '0');
                    let qty     = parseInt(input.value || '0', 10) || 0;
                    const name  = input.dataset.name || '';
                    const unit  = input.dataset.unit || '';

                    const lineTotal = price * qty;

                    // update row subtotal
                    const rowSubtotalEl = document.querySelector('[data-line-subtotal][data-item-id="'+itemId+'"]');
                    if (rowSubtotalEl) {
                        rowSubtotalEl.textContent = formatCurrency(lineTotal);
                    }

                    // 🔐 UPDATE HIDDEN FIELDS so backend gets latest values
                    const hiddenQty      = document.querySelector('[data-hidden-qty="'+itemId+'"]');
                    const hiddenSelected = document.querySelector('[data-hidden-selected="'+itemId+'"]');
                    const hiddenItem = document.querySelector('[data-hidden-item-id="'+itemId+'"]'); // Check if cart item exists

                    if (hiddenQty)      hiddenQty.value      = qty;
                    // Only update selection if the hidden item fields exist
                    if (hiddenSelected) hiddenSelected.value = cb.checked ? 1 : 0;
                    // If the item is not selected, remove it from the form data entirely by disabling the fields
                    // This is an alternative to setting the value to 0, which might be cleaner for the backend
                    if(hiddenItem) {
                        const allHiddenFields = document.querySelectorAll(`[data-hidden-item-id="${itemId}"], [data-hidden-qty="${itemId}"], [data-hidden-selected="${itemId}"]`);
                        allHiddenFields.forEach(field => {
                            if (cb.checked) {
                                field.removeAttribute('disabled');
                            } else {
                                field.setAttribute('disabled', 'disabled');
                            }
                        });
                    }

                    // if not selected, do not add to totals / summary list
                    if (!cb.checked) return;

                    totalItems += qty;
                    subtotal   += lineTotal;

                    // rebuild summary list display
                    if (summaryList) {
                        const row = document.createElement('div');
                        row.className = 'flex items-center justify-between px-3 py-2 text-xs sm:text-sm text-gray-700 dark:text-gray-200 border-b last:border-b-0 border-gray-100 dark:border-gray-700';
                        row.innerHTML = `
                            <div class="flex flex-col">
                                <span class="font-medium line-clamp-1">${name}</span>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400">
                                    ${unit ? unit + ' · ' : ''}${qty}x
                                </span>
                            </div>
                            <span class="font-semibold text-purple-600 dark:text-purple-400">
                                ${formatCurrency(lineTotal)}
                            </span>
                        `;
                        summaryList.appendChild(row);
                    }
                });

                const itemsCountEl = document.getElementById('summary-items-count');
                const subtotalEl   = document.getElementById('summary-subtotal');
                const totalEl      = document.getElementById('summary-total');

                if (itemsCountEl) itemsCountEl.textContent = totalItems;
                if (subtotalEl)   subtotalEl.textContent   = formatCurrency(subtotal);
                if (totalEl)      totalEl.textContent      = formatCurrency(subtotal); // no extra fees yet

                // Disable button if no items are selected
                if (checkoutButton) {
                    checkoutButton.disabled = (totalItems === 0);
                    checkoutButton.textContent = totalItems === 0 ? 'No Items Selected' : 'Proceed to Checkout';
                }
            }

            // Qty input direct edit
            qtyInputs.forEach(input => {
                input.addEventListener('input', () => {
                    const max = parseInt(input.getAttribute('max') || '999999', 10);
                    let val   = parseInt(input.value || '0', 10);

                    if (isNaN(val) || val < 1) val = 1;
                    if (val > max) val = max;

                    input.value = val;
                    recalcSummary();
                });
            });

            // Minus button
            minusBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const itemId = btn.dataset.itemId;
                    const input  = document.querySelector('.qty-input[data-item-id="'+itemId+'"]');
                    if (!input) return;

                    let val = parseInt(input.value || '0', 10) || 1;
                    val = Math.max(1, val - 1);
                    input.value = val;
                    recalcSummary();
                });
            });

            // Plus button (respect max stock)
            plusBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const itemId = btn.dataset.itemId;
                    const input  = document.querySelector('.qty-input[data-item-id="'+itemId+'"]');
                    if (!input) return;

                    const max = parseInt(input.getAttribute('max') || '999999', 10);
                    let val   = parseInt(input.value || '0', 10) || 1;
                    val = Math.min(max, val + 1);
                    input.value = val;
                    recalcSummary();
                });
            });

            // Checkbox toggle
            checkboxes.forEach(cb => {
                cb.addEventListener('change', recalcSummary);
            });

            // --- SWEETALERT2 INTEGRATION FOR CHECKOUT ---
            if (checkoutButton && checkoutForm) {
                checkoutButton.addEventListener('click', function(e) {
                    // Check if any item is selected first
                    const totalItems = parseInt(document.getElementById('summary-items-count').textContent);
                    if (totalItems === 0) {
                        Swal.fire({
                            title: 'Cart Empty',
                            text: 'Please select at least one item to proceed to checkout.',
                            icon: 'warning',
                            confirmButtonColor: '#4f46e5',
                        });
                        return;
                    }

                    // Check for GCash payment method and receipt
                    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                    if (paymentMethod === 'gcash') {
                        const receiptInput = document.querySelector('input[name="receipt_image"]');
                        if (!receiptInput.files.length) {
                             Swal.fire({
                                title: 'Missing Receipt',
                                text: 'Please upload your GCash payment receipt to proceed.',
                                icon: 'warning',
                                confirmButtonColor: '#4f46e5',
                            });
                            return;
                        }
                    }

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Confirm Order?',
                        html: `You are about to checkout <span class="font-bold text-indigo-600">${totalItems} items</span> with a total of <span class="font-bold text-indigo-600">${document.getElementById('summary-total').textContent}</span>.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4f46e5', // Indigo color
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Place Order!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form
                            checkoutForm.submit();
                        }
                    });
                });
            }
            // ---------------------------------------------

            // initial calc
            recalcSummary();
        });
    </script>
</x-app-layout>