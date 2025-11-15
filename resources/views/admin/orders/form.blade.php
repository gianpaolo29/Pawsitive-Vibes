{{-- resources/views/admin/orders/create-walkin.blade.php --}}
<x-admin-layout :breadcrumbs="collect()">
    <div class="max-w-6xl mx-auto"
         x-data="{
            showProductModal: false,
            products: @js($products),
            productSearch: '',
            orderItems: [],

            get filteredProducts() {
                if (!this.productSearch) return this.products;
                const term = this.productSearch.toLowerCase();
                return this.products.filter(p => {
                    const name = (p.name || '').toLowerCase();
                    const sku  = (p.sku || '').toLowerCase();
                    return name.includes(term) || sku.includes(term);
                });
            },

            subtotal() {
                return this.orderItems.reduce((s, i) =>
                    s + (Number(i.unit_price || 0) * Number(i.quantity || 0)), 0
                );
            },

            grandTotal() { return this.subtotal(); },

            addItem(p) {
                if (!p) return;

                const maxStock = Number(p.stock || 0);
                if (maxStock <= 0) {
                    // Optional: you can show a toast/alert here if you want
                    return;
                }

                const idx = this.orderItems.findIndex(i => i.product_id === p.id);

                if (idx >= 0) {
                    // Already in cart – increment only up to stock
                    if (this.orderItems[idx].quantity < maxStock) {
                        this.orderItems[idx].quantity++;
                    }
                    return;
                }

                this.orderItems.push({
                    product_id: p.id,
                    name: p.name,
                    unit_price: Number(p.price || 0),
                    quantity: 1,
                    unit: p.unit,
                    image_url: p.image_url,
                    max_qty: maxStock,
                });

                this.showProductModal = false;
            },

            removeItem(i) {
                this.orderItems.splice(i, 1);
            }
         }"
    >
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-violet-600">Transactions</a>
                <span class="mx-2">/</span>
                <span class="font-medium text-gray-700">New Walk-in</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">Cancel</a>
                <button type="submit" form="create-order-form"
                        class="px-5 py-2 rounded-lg bg-violet-600 text-white font-medium hover:bg-violet-700 shadow-md">
                    Save Transaction
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-300 bg-red-50 p-4 text-red-700 mb-6">
                <div class="font-semibold mb-2">Please correct the following errors:</div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <form method="POST" id="create-order-form" action="{{ route('admin.orders.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ $walkInUserId }}">
                    <input type="hidden" name="subtotal" x-bind:value="subtotal().toFixed(2)">
                    <input type="hidden" name="grand_total" x-bind:value="grandTotal().toFixed(2)">

                    {{-- CUSTOMER (fixed Walk-in) --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Customer</h2>
                        <p class="text-gray-700">Walk-in Customer</p>
                    </div>

                    {{-- PRODUCTS --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Products</h2>
                            <button type="button" @click="showProductModal = true"
                                    class="inline-flex items-center gap-1.5 text-violet-600 font-medium hover:text-violet-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Add Product
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, index) in orderItems" :key="index">
                                <div class="flex items-center p-3 border border-gray-200 rounded-xl bg-gray-50">
                                    <div class="flex items-center gap-3 w-1/2">
                                        <img :src="item.image_url || '{{ asset('images/placeholder-product.png') }}'"
                                             class="w-10 h-10 rounded-md object-cover" alt="">
                                        <div>
                                            <p class="font-medium text-gray-900" x-text="item.name"></p>
                                            <p class="text-xs text-gray-500"
                                               x-text="'₱' + Number(item.unit_price||0).toFixed(2) + ' • ' + (item.unit||'')"></p>
                                            <p class="text-[11px] text-gray-400"
                                               x-text="'Stock: ' + (item.max_qty ?? 0)"></p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 w-1/4 justify-end">
                                        {{-- hidden fields that the controller expects --}}
                                        <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.product_id">
                                        <input type="hidden" :name="'items['+index+'][unit]'"       :value="item.unit || ''">
                                        <input type="hidden" :name="'items['+index+'][unit_price]'"  :value="Number(item.unit_price||0).toFixed(2)">
                                        <input type="hidden" :name="'items['+index+'][name]'"        :value="item.name">

                                        <button type="button"
                                                @click="item.quantity > 1 ? item.quantity-- : null"
                                                class="p-1 text-gray-600 hover:text-violet-600"
                                                :disabled="item.quantity <= 1">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2">
                                                <path d="M5 12h14"/>
                                            </svg>
                                        </button>

                                        <input type="number" min="1"
                                               :max="item.max_qty ?? null"
                                               :name="'items['+index+'][quantity]'"
                                               x-model.number="item.quantity"
                                               @input="
                                                    if (item.quantity < 1) item.quantity = 1;
                                                    if (item.max_qty && item.quantity > item.max_qty) {
                                                        item.quantity = item.max_qty;
                                                    }
                                               "
                                               class="w-12 text-center text-sm rounded-lg border-gray-300 p-1 focus:ring-violet-500">

                                        <button type="button"
                                                @click="
                                                    if (!item.max_qty || item.quantity < item.max_qty) {
                                                        item.quantity++;
                                                    }
                                                "
                                                class="p-1 text-gray-600 hover:text-violet-600"
                                                :disabled="item.max_qty && item.quantity >= item.max_qty">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2">
                                                <path d="M12 5v14M5 12h14"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex items-center justify-end w-1/4 gap-4">
                                        <span class="font-bold text-gray-900 w-20 text-right"
                                              x-text="'₱' + (Number(item.unit_price||0) * Number(item.quantity||0)).toFixed(2)"></span>
                                        <button type="button" @click="removeItem(index)"
                                                class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50"
                                                title="Remove">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                                         a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="orderItems.length === 0">
                                <div class="flex flex-col items-center justify-center p-8 border border-dashed border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                                    <svg class="h-10 w-10 text-gray-400 mb-2" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="1.5">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4zM3 6h18M16 10a4 4 0 0 1-8 0"/>
                                    </svg>
                                    <p class="text-sm font-medium">No products added yet</p>
                                    <p class="text-xs mt-1">Click “Add Product” to start</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- PAYMENT --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 space-y-3">
                        <h2 class="text-xl font-semibold text-gray-800">Payment</h2>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="payment[method]" value="cash" class="text-violet-600" checked>
                                <span>Cash</span>
                            </label>
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="payment[method]" value="gcash" class="text-violet-600">
                                <span>GCash</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">
                            Cash will auto-mark as paid; GCash will be pending until verified.
                        </p>
                    </div>
                </form>
            </div>

            {{-- SUMMARY --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Transaction Summary</h2>
                    <div class="space-y-3 mb-6 border-b pb-4">
                        <template x-for="(item, index) in orderItems" :key="index">
                            <div class="flex justify-between items-start text-sm">
                                <span class="text-gray-700 leading-tight" x-text="item.name"></span>
                                <div class="text-right ml-4">
                                    <span class="text-gray-500 text-xs"
                                          x-text="(item.quantity||0) + ' × ₱' + Number(item.unit_price||0).toFixed(2)"></span>
                                    <p class="font-medium text-gray-900"
                                       x-text="'₱' + (Number(item.unit_price||0) * Number(item.quantity||0)).toFixed(2)"></p>
                                </div>
                            </div>
                        </template>
                        <template x-if="orderItems.length === 0">
                            <p class="text-sm text-gray-500 py-2">Add products to see the summary.</p>
                        </template>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span x-text="'₱' + subtotal().toFixed(2)">₱0.00</span>
                        </div>
                        <hr class="my-2 border-gray-200">
                        <div class="flex justify-between font-bold text-lg text-gray-900">
                            <span>Total</span>
                            <span x-text="'₱' + grandTotal().toFixed(2)">₱0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Select Product Modal --}}
        <div x-cloak x-show="showProductModal"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
             @keydown.escape.window="showProductModal=false">
            <div class="bg-white w-full max-w-2xl rounded-xl shadow-xl overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-semibold text-gray-800">Select Product</h3>
                    <button class="p-2 rounded hover:bg-gray-100" @click="showProductModal=false">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="p-4 border-b">
                    <input type="text"
                           x-model="productSearch"
                           placeholder="Search product name or SKU..."
                           class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-violet-500 focus:border-violet-500" />
                </div>

                <div class="p-4 max-h-[60vh] overflow-y-auto space-y-3">
                    <template x-for="p in filteredProducts" :key="p.id">
                        <div class="flex items-center justify-between border rounded-lg p-3">
                            <div class="flex items-center gap-3">
                                <img :src="p.image_url || '{{ asset('images/placeholder-product.png') }}'"
                                     class="w-12 h-12 rounded object-cover" alt="">
                                <div>
                                    <div class="font-medium text-gray-900" x-text="p.name"></div>
                                    <div class="text-xs text-gray-500"
                                         x-text="'₱' + Number(p.price||0).toFixed(2) + ' • ' + (p.unit||'') + ' • Stock: ' + (p.stock ?? 0)">
                                    </div>
                                </div>
                            </div>
                            <button type="button"
                                    class="px-3 py-1.5 rounded bg-violet-600 text-white hover:bg-violet-700 disabled:opacity-50"
                                    :disabled="(p.stock ?? 0) <= 0"
                                    @click="addItem(p)">
                                Add
                            </button>
                        </div>
                    </template>

                    <template x-if="filteredProducts.length === 0">
                        <p class="text-sm text-gray-500">No products match your search.</p>
                    </template>
                </div>

                <div class="p-4 border-t text-right">
                    <button class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200" @click="showProductModal=false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
