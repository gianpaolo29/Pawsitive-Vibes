<x-app-layout>
    <div class="max-w-7xl mx-auto my-12">
        <form
            action="{{ route('customer.donations.store') }}"
            method="POST"
            enctype="multipart/form-data"
            x-data="donationForm({{ $products->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'price' => $p->price,
            ])->values()->toJson() }})"
            x-cloak
            class="space-y-8"
        >
            @csrf

            {{-- DONATION TYPE CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- PRODUCT DONATION CARD --}}
                <label class="cursor-pointer">
                    <input
                        type="radio"
                        name="type"
                        value="products"
                        x-model="type"
                        class="peer hidden"
                    >
                    <div
                        class="border rounded-xl p-4 h-full flex flex-col gap-2
                               bg-white shadow-sm
                               transition-all duration-150
                               peer-checked:border-indigo-500
                               peer-checked:ring-2 peer-checked:ring-indigo-200
                               peer-checked:shadow-md"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-wide text-indigo-600">
                                Product Donation
                            </span>
                            <span class="inline-flex items-center justify-center px-2 py-1 text-[11px] font-medium rounded-full bg-indigo-50 text-indigo-700">
                                In-Kind
                            </span>
                        </div>

                        <div class="mt-1">
                            <h4 class="text-base font-semibold text-gray-900">
                                Donate Products to Animal Shelters
                            </h4>
                        </div>
                    </div>
                </label>

                {{-- CASH DONATION CARD --}}
                <label class="cursor-pointer">
                    <input
                        type="radio"
                        name="type"
                        value="cash"
                        x-model="type"
                        class="peer hidden"
                    >
                    <div
                        class="border rounded-xl p-4 h-full flex flex-col gap-2
                               bg-white shadow-sm
                               transition-all duration-150
                               peer-checked:border-emerald-500
                               peer-checked:ring-2 peer-checked:ring-emerald-200
                               peer-checked:shadow-md"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold uppercase tracking-wide text-emerald-600">
                                Cash Donation
                            </span>
                            <span class="inline-flex items-center justify-center px-2 py-1 text-[11px] font-medium rounded-full bg-emerald-50 text-emerald-700">
                                Monetary
                            </span>
                        </div>

                        <div class="mt-1">
                            <h4 class="text-base font-semibold text-gray-900">
                                Make a monetary donation via GCash for maximum flexibility
                            </h4>
                        </div>
                    </div>
                </label>
            </div>

            {{-- PRODUCTS SECTION (WHEN type = products) --}}
            <div x-show="type === 'products'" x-transition>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-sm font-semibold text-gray-800">
                        Products to Donate
                    </h2>
                    <button
                        type="button"
                        @click="addItem()"
                        class="text-xs px-3 py-1 rounded-full bg-indigo-600 text-white hover:bg-indigo-700"
                    >
                        + Add Product
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-3 items-end">
                        {{-- Product Select --}}
                        <div class="md:col-span-6">
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Product
                            </label>
                            <select
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                x-model="item.product_id"
                                :name="`products[${index}][product_id]`"
                                :required="type === 'products'"
                            >
                                <option value="">Select product</option>
                                <template x-for="product in allProducts" :key="product.id">
                                    <option :value="product.id" x-text="`${product.name} (₱${product.price})`"></option>
                                </template>
                            </select>
                        </div>

                        {{-- Quantity --}}
                        <div class="md:col-span-3">
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Quantity
                            </label>
                            <input
                                type="number"
                                min="1"
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                x-model.number="item.quantity"
                                :name="`products[${index}][quantity]`"
                                :required="type === 'products'"
                            >
                        </div>

                        {{-- Line Total --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Line Total (₱)
                            </label>
                            <div class="text-sm font-semibold text-gray-800">
                                <span x-text="lineTotal(item).toFixed(2)"></span>
                            </div>
                        </div>

                        {{-- Remove --}}
                        <div class="md:col-span-1 flex justify-start md:justify-end">
                            <button
                                type="button"
                                @click="removeItem(index)"
                                x-show="items.length > 1"
                                class="inline-flex items-center text-xs px-3 py-2 rounded-lg border border-red-200 text-red-600 hover:bg-red-50"
                            >
                                X
                            </button>
                        </div>
                    </div>
                </template>

                {{-- TOTAL AMOUNT --}}
                <div class="mt-4 flex justify-end">
                    <div class="text-right">
                        <div class="text-xs uppercase text-gray-500">
                            Estimated Total Value
                        </div>
                        <div class="text-xl font-bold text-gray-900">
                            ₱ <span x-text="total.toFixed(2)"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CASH SECTION (WHEN type = cash) --}}
            <div x-show="type === 'cash'" x-transition>
                <h2 class="text-sm font-semibold text-gray-800 mb-2">
                    Cash Donation Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Amount (₱)
                        </label>
                        <input
                            type="number"
                            min="1"
                            step="0.01"
                            name="amount"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="e.g., 500"
                            :required="type === 'cash'"
                        >
                    </div>
                </div>
            </div>

            {{-- DONOR INFO (ALWAYS SHOWN) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Phone Number
                </label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                >
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Receipt
                    </label>
                    <input
                        type="file"
                        name="receipt"
                        class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        required
                        accept="image/*"
                    >
                </div>
            </div>

            {{-- SUBMIT --}}
            <div>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700"
                >
                    Submit Donation
                </button>
            </div>
        </form>
    </div>

    {{-- Alpine logic --}}
    <script>
        function donationForm(allProducts) {
            return {
                type: 'products', // default
                allProducts: allProducts,
                items: [],

                addItem() {
                    this.items.push({ product_id: '', quantity: 1 });
                },

                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },

                findProduct(id) {
                    return this.allProducts.find(p => p.id == id);
                },

                lineTotal(item) {
                    const product = this.findProduct(item.product_id);
                    if (!product) return 0;
                    const qty = item.quantity || 0;
                    return product.price * qty;
                },

                get total() {
                    return this.items.reduce((sum, item) => {
                        return sum + this.lineTotal(item);
                    }, 0);
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Handle SUCCESS/ERROR flash messages (e.g., after successful store or generic errors)
            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
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
        });
    </script>
</x-app-layout>
