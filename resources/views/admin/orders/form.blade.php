<x-admin-layout :breadcrumbs="collect()">
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-6xl mx-auto"
        x-data="{
            showProductModal: false,
            products: @js($products),
            customerType: 'walkin',
            productSearch: '',
            orderItems: [],
            selectedCustomer: null, // ADD THIS - was missing

            get filteredProducts() {
                if (!this.productSearch) return this.products;
                const term = this.productSearch.toLowerCase();
                return this.products.filter(p => {
                    // Add null checks for product properties
                    const name = (p?.name || '').toLowerCase();
                    const sku  = (p?.sku || '').toLowerCase();
                    return name.includes(term) || sku.includes(term);
                });
            },

            subtotal() {
                return this.orderItems.reduce((s, i) =>
                    s + (Number(i?.unit_price || 0) * Number(i?.quantity || 0)), 0
                );
            },

            grandTotal() { return this.subtotal(); },

            addItem(p) {
                if (!p) return;

                // Add null-safe property access
                const maxStock = Number(p?.stock || 0);
                if (maxStock <= 0) {
                    return;
                }

                const idx = this.orderItems.findIndex(i => i?.product_id === p?.id);

                if (idx >= 0) {
                    // Already in cart – increment only up to stock
                    if (this.orderItems[idx]?.quantity < maxStock) {
                        this.orderItems[idx].quantity++;
                    }
                    return;
                }

                this.orderItems.push({
                    product_id: p?.id,
                    name: p?.name || 'Unknown Product',
                    unit_price: Number(p?.price || 0),
                    quantity: 1,
                    unit: p?.unit || 'unit',
                    image_url: p?.image_url || '{{ asset('images/placeholder-product.png') }}',
                    max_qty: maxStock,
                });

                this.showProductModal = false;
            },

            removeItem(i) {
                if (i >= 0 && i < this.orderItems.length) {
                    this.orderItems.splice(i, 1);
                }
            }
        }"
    >
        {{-- HEADER/BREADCRUMBS & ACTION BUTTONS --}}
        <div class="flex items-start justify-between mb-4 px-4 sm:px-0">
            <div class="flex items-center text-sm text-gray-500 pt-1">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-violet-600">Transactions</a>
                <span class="mx-2">/</span>
                <span class="font-medium text-gray-700">New Walk-in</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 font-medium">Cancel</a>
                <button type="submit" form="create-order-form"
                        class="px-5 py-2 rounded-lg bg-violet-600 text-white font-medium hover:bg-violet-700 shadow-md transition ease-in-out duration-150">
                    Save Transaction
                </button>
            </div>
        </div>

        <div class="px-4 sm:px-0">
            {{-- Error alert removed as requested --}}
        </div>

        <div class="grid lg:grid-cols-3 gap-6 px-4 sm:px-0">
            <div class="lg:col-span-2 space-y-4">
                <form method="POST" id="create-order-form" action="{{ route('admin.orders.store') }}" class="space-y-4">
                    @csrf

                    {{-- Hidden inputs --}}
                    <input type="hidden" name="subtotal" x-bind:value="subtotal().toFixed(2)">
                    <input type="hidden" name="grand_total" x-bind:value="grandTotal().toFixed(2)">
                    <input type="hidden" name="user_id" x-bind:value="selectedCustomer || ''">
                    
                    {{-- CUSTOMER SECTION --}}
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 space-y-3">
                        <h2 class="text-xl font-semibold text-gray-800">Customer</h2>

                        {{-- Toggle --}}
                        <div class="flex gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="customer_type" value="walkin"
                                    class="form-radio text-violet-600 focus:ring-violet-500"
                                    x-model="customerType">
                                <span>Walk-in Customer</span>
                            </label>

                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="customer_type" value="registered"
                                    class="form-radio text-violet-600 focus:ring-violet-500"
                                    x-model="customerType">
                                <span>Registered Customer</span>
                            </label>
                        </div>

                        {{-- Walk-in Display --}}
                        <div x-show="customerType === 'walkin'" class="mt-2 p-3 rounded-lg bg-gray-50 border">
                            <p class="text-gray-700 font-medium">Walk-in Customer</p>
                        </div>

                        {{-- Registered Search --}}
                        <div x-show="customerType === 'registered'"
                            class="mt-2 p-3 rounded-lg bg-gray-50 border space-y-2"
                            x-data="{
                                search: '',
                                selectedCustomer: '',
                                open: false,
                                customers: @js($registeredCustomers),
                                get filtered() {
                                    if (!this.search) return this.customers;
                                    const s = this.search.toLowerCase();
                                    return this.customers.filter(c => {
                                        // Add null-safe property access
                                        const fullName = ((c?.fname || '') + ' ' + (c?.lname || '')).toLowerCase();
                                        const username = (c?.username || '').toLowerCase();
                                        const email = (c?.email || '').toLowerCase();
                                        return fullName.includes(s) || username.includes(s) || email.includes(s);
                                    });
                                },
                                choose(c) {
                                    if (!c) return;
                                    
                                    // Set the main form user_id safely
                                    const hiddenInput = document.querySelector('input[name=\'user_id\']');
                                    if (hiddenInput) {
                                        hiddenInput.value = c?.id || '';
                                    }
                                    
                                    // Update Alpine data safely
                                    this.selectedCustomer = c?.id || '';
                                    this.search = (c?.fname || '') + ' ' + (c?.lname || '') + (c?.username ? ' (@' + c.username + ')' : '');
                                    this.open = false;
                                    
                                    // Update parent component
                                    if (this.$root && this.$root.__x) {
                                        this.$root.__x.$data.selectedCustomer = c?.id || '';
                                    }
                                }
                            }">

                            <label class="text-sm font-medium text-gray-600 block">Select Customer:</label>

                            {{-- Search Box --}}
                            <input type="text"
                                x-model="search"
                                @click="open = true"
                                @focus="open = true"
                                @keyup.escape.window="open = false"
                                placeholder="Search by name, username, or email..."
                                class="w-full rounded-lg border-gray-300 shadow-sm px-3 py-2 text-sm focus:ring-violet-500 focus:border-violet-500">

                            {{-- Dropdown --}}
                            <div x-show="open && filtered.length > 0"
                                @click.away="open = false"
                                class="absolute z-10 w-[calc(100%-2rem)] sm:w-[calc((100%/3*2)-2rem)] lg:w-[calc((100%/3*2)-4rem)] xl:w-[calc((100%/3*2)-4rem)] max-w-[700px] border rounded-xl bg-white shadow-xl max-h-60 overflow-y-auto mt-1">

                                <template x-for="cust in filtered" :key="cust.id">
                                    <div @click="choose(cust)"
                                        class="px-4 py-2 text-sm cursor-pointer hover:bg-violet-50 transition ease-in-out duration-150">
                                        <span class="font-medium" x-text="(cust?.fname || '') + ' ' + (cust?.lname || '')"></span>
                                        <span class="text-gray-400 text-xs ml-1" x-text="cust?.email || ''"></span>
                                        <br>
                                        <span class="text-gray-500 text-xs"
                                            x-text="cust?.username ? '@' + cust.username : ''"></span>
                                    </div>
                                </template>
                            </div>
                            <template x-if="open && filtered.length === 0">
                                <div class="px-4 py-2 text-sm text-gray-400 border rounded-lg bg-white shadow-lg mt-1">
                                    No matching customer found.
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- PRODUCTS SECTION - Rest of your products code remains the same but with added null checks --}}
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100">
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-xl font-semibold text-gray-800">Products</h2>
                            <button type="button" @click="showProductModal = true"
                                    class="inline-flex items-center gap-1.5 text-sm text-violet-600 font-medium hover:text-violet-700 transition ease-in-out duration-150 p-2 -mr-2 rounded-lg hover:bg-violet-50">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                Add Product
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(item, index) in orderItems" :key="index">
                                <div class="flex flex-col sm:flex-row items-center justify-between p-3 border border-gray-200 rounded-xl bg-gray-50 transition ease-in-out duration-150 hover:border-violet-300">
                                    
                                    {{-- Product Info with null checks --}}
                                    <div class="flex items-center gap-3 w-full sm:w-1/2 mb-3 sm:mb-0">
                                        <img :src="item?.image_url || '{{ asset('images/placeholder-product.png') }}'"
                                            class="w-10 h-10 rounded-md object-cover flex-shrink-0" alt="">
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 truncate" x-text="item?.name || 'Unknown Product'"></p>
                                            <p class="text-xs text-gray-500"
                                               x-text="'₱' + Number(item?.unit_price||0).toFixed(2) + ' / ' + (item?.unit||'unit')"></p>
                                            <p class="text-[11px] text-gray-400"
                                               x-text="'Stock: ' + (item?.max_qty ?? 0)"></p>
                                        </div>
                                    </div>

                                    {{-- Hidden Fields with null checks --}}
                                    <input type="hidden" :name="'items['+index+'][product_id]'" :value="item?.product_id || ''">
                                    <input type="hidden" :name="'items['+index+'][unit]'"    :value="item?.unit || ''">
                                    <input type="hidden" :name="'items['+index+'][unit_price]'"  :value="Number(item?.unit_price||0).toFixed(2)">
                                    <input type="hidden" :name="'items['+index+'][name]'"      :value="item?.name || ''">

                                    {{-- Quantity Control & Subtotal --}}
                                    <div class="flex items-center justify-between w-full sm:w-1/2 gap-3">
                                        {{-- Quantity --}}
                                        <div class="flex items-center justify-start sm:justify-center gap-0 w-24 flex-shrink-0">
                                            <button type="button"
                                                    @click="item?.quantity > 1 ? item.quantity-- : null"
                                                    class="p-1 text-gray-600 hover:text-violet-600 disabled:opacity-30 disabled:hover:text-gray-600 transition"
                                                    :disabled="(item?.quantity || 0) <= 1">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"><path d="M5 12h14"/></svg>
                                            </button>

                                            <input type="number" min="1"
                                                    :max="item?.max_qty ?? null"
                                                    :name="'items['+index+'][quantity]'"
                                                    x-model.number="item.quantity"
                                                    @input="
                                                        if (item?.quantity < 1) item.quantity = 1;
                                                        if (item?.max_qty && item.quantity > item.max_qty) {
                                                            item.quantity = item.max_qty;
                                                        }
                                                    "
                                                    class="w-12 text-center text-sm rounded-lg border-gray-300 p-1 focus:ring-violet-500 focus:border-violet-500 shadow-sm">

                                            <button type="button"
                                                    @click="
                                                        if (!item?.max_qty || item.quantity < item.max_qty) {
                                                            item.quantity++;
                                                        }
                                                    "
                                                    class="p-1 text-gray-600 hover:text-violet-600 disabled:opacity-30 disabled:hover:text-gray-600 transition"
                                                    :disabled="item?.max_qty && item.quantity >= item.max_qty">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                            </button>
                                        </div>

                                        {{-- Line Total & Remove --}}
                                        <div class="flex items-center justify-end flex-shrink-0 gap-3">
                                            <span class="font-bold text-gray-900 w-20 text-right text-base"
                                                     x-text="'₱' + (Number(item?.unit_price||0) * Number(item?.quantity||0)).toFixed(2)"></span>
                                            <button type="button" @click="removeItem(index)"
                                                     class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-100 transition"
                                                     title="Remove Item">
                                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                     <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                                             a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Empty State --}}
                            <template x-if="orderItems.length === 0">
                                <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 text-gray-500">
                                    <svg class="h-10 w-10 text-gray-400 mb-3" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4zM3 6h18M16 10a4 4 0 0 1-8 0"/>
                                    </svg>
                                    <p class="text-sm font-medium">No products added yet</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- PAYMENT SECTION (unchanged) --}}
                    <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 space-y-2">
                        <h2 class="text-xl font-semibold text-gray-800">Payment Method</h2>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment[method]" value="cash"
                                    class="form-radio text-violet-600 focus:ring-violet-500" checked>
                                <span>Cash</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment[method]" value="gcash"
                                    class="form-radio text-violet-600 focus:ring-violet-500">
                                <span>GCash</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">
                            Cash will auto-mark as paid; GCash will be pending until verified.
                        </p>
                    </div>
                </form>
            </div>

            {{-- SUMMARY CARD with null checks --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 lg:sticky lg:top-24">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Transaction Summary</h2>
                    <div class="space-y-2">
                        <template x-for="(item, index) in orderItems" :key="index">
                            <div class="flex justify-between items-start text-sm">
                                <span class="text-gray-700 leading-tight w-2/3 truncate" x-text="item?.name || 'Unknown Product'"></span>
                                <div class="text-right ml-4 flex-shrink-0">
                                    <span class="text-gray-500 text-xs block"
                                             x-text="(item?.quantity||0) + ' × ₱' + Number(item?.unit_price||0).toFixed(2)"></span>
                                    <p class="font-medium text-gray-900"
                                       x-text="'₱' + (Number(item?.unit_price||0) * Number(item?.quantity||0)).toFixed(2)"></p>
                                </div>
                            </div>
                        </template>
                        <template x-if="orderItems.length === 0">
                            <p class="text-sm text-gray-500 py-1">Add products to see the summary.</p>
                        </template>
                    </div>

                    <div class="space-y-2 pt-4 border-t mt-4">
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Subtotal</span>
                            <span x-text="'₱' + subtotal().toFixed(2)">₱0.00</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg text-gray-900">
                            <span>Total</span>
                            <span x-text="'₱' + grandTotal().toFixed(2)">₱0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Select Product Modal with null checks --}}
        <div x-cloak x-show="showProductModal"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
             @keydown.escape.window="showProductModal=false"
             x-trap.noscroll.inert="showProductModal">
            <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden transition-all duration-300">
                <div class="flex flex-col">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-xl font-bold text-gray-800">Select Product</h3>
                        <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-gray-700 transition" @click="showProductModal=false">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 border-b">
                        <input type="text"
                               x-model="productSearch"
                               placeholder="Search product name or SKU..."
                               class="w-full px-4 py-2 border rounded-xl text-base shadow-sm focus:ring-violet-500 focus:border-violet-500" />
                    </div>

                    <div class="p-4 max-h-[60vh] overflow-y-auto space-y-3">
                        <template x-for="p in filteredProducts" :key="p.id">
                            <div class="flex items-center justify-between border border-gray-200 rounded-xl p-3 bg-white hover:shadow-md transition ease-in-out duration-150">
                                <div class="flex items-center gap-3 w-4/5">
                                    <img :src="p?.image_url || '{{ asset('images/placeholder-product.png') }}'"
                                         class="w-14 h-14 rounded-lg object-cover flex-shrink-0" alt="">
                                    <div class="min-w-0">
                                        <div class="font-medium text-gray-900 truncate" x-text="p?.name || 'Unknown Product'"></div>
                                        <div class="text-xs text-gray-500 mt-0.5"
                                             x-text="'₱' + Number(p?.price||0).toFixed(2) + ' / ' + (p?.unit||'unit')">
                                        </div>
                                        <div class="text-xs text-gray-400"
                                             x-text="'Stock: ' + (p?.stock ?? 0)">
                                        </div>
                                    </div>
                                </div>
                                <button type="button"
                                         class="px-4 py-2 text-sm rounded-lg bg-violet-600 text-white hover:bg-violet-700 disabled:opacity-50 disabled:cursor-not-allowed transition flex-shrink-0"
                                         :disabled="(p?.stock ?? 0) <= 0"
                                         @click="addItem(p)">
                                    <span x-text="(p?.stock ?? 0) <= 0 ? 'Out of Stock' : 'Add'">Add</span>
                                </button>
                            </div>
                        </template>

                        <template x-if="filteredProducts.length === 0">
                            <p class="text-sm text-gray-500 p-4 bg-gray-50 rounded-lg text-center">No products match your search or products list is empty.</p>
                        </template>
                    </div>
                </div>

                <div class="p-4 border-t text-right bg-gray-50">
                    <button class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium transition" @click="showProductModal=false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SWEETALERT SCRIPT BLOCK FOR FLASH MESSAGES AND ERRORS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Handle SUCCESS/ERROR flash messages (e.g., after successful store or generic errors)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Transaction Saved!',
                    text: '{{ session('success') }}',
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

            // 2. Handle Validation Errors (Existing logic)
            @if ($errors->any())
                const errors = @json($errors->all());
                
                // Check specifically for the 'items field is required' error
                const itemsRequired = errors.some(error => error.includes('The items field is required'));

                if (itemsRequired) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Products',
                        text: 'You must add at least one product to the transaction before saving.',
                        confirmButtonText: 'Add Products',
                        confirmButtonColor: '#7c3aed'
                    }).then((result) => {
                        // Open the product selection modal if the user clicks 'Add Products'
                        if (result.isConfirmed) {
                            // Find the Alpine component root element
                            const root = document.querySelector('[x-data]');
                            if (root && root.__x) {
                                // Set the Alpine data property to true
                                root.__x.$data.showProductModal = true;
                            }
                        }
                    });
                } else {
                    // Handle other general validation errors with a generic SweetAlert modal
                    let message = 'Please correct the following errors: \n' + errors.join('\n');
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: message.replace(/\n/g, '<br>'),
                        confirmButtonColor: '#7c3aed'
                    });
                }
            @endif
        });
    </script>
</x-admin-layout>