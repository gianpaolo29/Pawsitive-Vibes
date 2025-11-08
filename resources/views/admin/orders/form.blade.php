<x-admin-layout :breadcrumbs="collect()">
    <div class="max-w-6xl mx-auto"
         x-data="{
            showProductModal: false,
            selectedProduct: null,

            // Prefill items (edit) -> $order->items ; create -> empty
            orderItems: [
                @if(isset($order) && $order->items && $order->items->isNotEmpty())
                    @foreach($order->items as $it)
                        {
                            product_id: {{ $it->product_id ?? 'null' }},
                            name: @js($it->product_name ?? ''),
                            unit_price: {{ number_format((float)$it->unit_price, 2, '.', '') }},
                            quantity: {{ (int)$it->quantity }},
                            unit: @js($it->unit ?? ''),
                            image_url: @js($it->image_url ?? null),
                        },
                    @endforeach
                @endif
            ],

            taxRate: 0.12, // client preview only; server computes official totals
            subtotal(){ return this.orderItems.reduce((s,i)=> s + (Number(i.unit_price||0)*Number(i.quantity||0)), 0); },
            taxAmount(){ return this.subtotal() * this.taxRate; },
            grandTotal(){ return this.subtotal() + this.taxAmount(); },

            addItem(product){
                if(!product) return;
                this.orderItems.push({
                    product_id: product.id ?? '',
                    name: product.name ?? '',
                    unit_price: Number(product.price ?? 0),
                    quantity: 1,
                    unit: product.unit ?? '',
                    image_url: product.image_url ?? null,
                });
                this.showProductModal = false;
            },
            removeItem(i){ this.orderItems.splice(i,1); }
         }">

        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center text-sm text-gray-500">
                <a href="{{ route('admin.orders.index') }}" class="hover:text-violet-600">Transactions</a>
                <span class="mx-2">/</span>
                <span class="font-medium text-gray-700">
                    {{ isset($order) && $order->exists ? 'Edit Transaction' : 'New Transaction' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150">Cancel</a>
                <button type="submit" form="create-order-form"
                        class="px-5 py-2 rounded-lg bg-violet-600 text-white font-medium hover:bg-violet-700 shadow-md transition duration-150">
                    Save Transaction
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-red-300 bg-red-50 p-4 text-red-700 mb-6 shadow-sm">
                <div class="font-semibold mb-2">Please correct the following errors:</div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            {{ isset($order) && $order->exists ? 'Edit Order' : 'Create New Order' }}
            @if(isset($order) && $order->order_number)
                <span class="ml-2 text-sm text-gray-500">#{{ $order->order_number }}</span>
            @endif
        </h1>

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <form method="POST" id="create-order-form"
                      enctype="multipart/form-data"
                      action="{{ isset($order) && $order->exists
                                  ? route('admin.orders.update', $order)
                                  : route('admin.orders.store') }}"
                      class="space-y-6">
                    @csrf
                    @if(isset($order) && $order->exists)
                        @method('PUT')
                    @endif

                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Customer</h2>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Customer *</label>
                        <select name="user_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-violet-500 focus:border-violet-500" required>
                            <option value="">Choose customer…</option>
                            @foreach(($customers ?? []) as $c)
                                <option value="{{ $c->id }}"
                                    @selected(old('user_id', isset($order)? $order->user_id : '') == $c->id)>
                                    {{ $c->username }} @if($c->fname || $c->lname) — {{ trim(($c->fname ?? '').' '.($c->lname ?? '')) }} @endif
                                </option>
                            @endforeach
                        </select>

                        @if(isset($order))
                            <div class="mt-3 text-xs text-gray-500">
                                Status:
                                <span class="px-2 py-1 rounded bg-gray-100">{{ $order->status }}</span>
                                <span class="px-2 py-1 rounded bg-gray-100">{{ $order->payment_status }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Products</h2>
                            <button type="button" @click="showProductModal = true"
                                    class="inline-flex items-center gap-1.5 text-violet-600 font-medium hover:text-violet-700 transition duration-150">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                Add Product
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, index) in orderItems" :key="index">
                                <div class="flex items-center p-3 border border-gray-200 rounded-xl bg-gray-50">
                                    <div class="flex items-center gap-3 w-1/2">
                                        <img :src="item.image_url ?? 'https://via.placeholder.com/40'"
                                             class="w-10 h-10 rounded-md object-cover flex-shrink-0" alt="Product">
                                        <div>
                                            <p class="font-medium text-gray-900" x-text="item.name"></p>
                                            <p class="text-xs text-gray-500" x-text="'₱' + Number(item.unit_price||0).toFixed(2) + ' each'"></p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 w-1/4 justify-end">
                                        <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.product_id">
                                        <input type="hidden" :name="'items['+index+'][unit]'" :value="item.unit ?? ''">
                                        <input type="hidden" :name="'items['+index+'][unit_price]'" :value="Number(item.unit_price||0).toFixed(2)">

                                        <button type="button" @click="item.quantity>1 ? item.quantity-- : null"
                                                class="p-1 text-gray-600 hover:text-violet-600 disabled:opacity-50"
                                                :disabled="item.quantity <= 1">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/></svg>
                                        </button>
                                        <input type="number" min="1"
                                               :name="'items['+index+'][quantity]'"
                                               x-model.number="item.quantity"
                                               class="w-12 text-center text-sm rounded-lg border-gray-300 p-1 focus:ring-violet-500">
                                        <button type="button" @click="item.quantity++"
                                                class="p-1 text-gray-600 hover:text-violet-600">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                        </button>
                                    </div>

                                    <div class="flex items-center justify-end w-1/4 gap-4">
                                        <span class="font-bold text-gray-900 w-20 text-right"
                                              x-text="'₱' + (Number(item.unit_price||0) * Number(item.quantity||0)).toFixed(2)"></span>
                                        <button type="button" @click="removeItem(index)"
                                                class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition duration-150" title="Remove Item">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="orderItems.length === 0">
                                <div class="flex flex-col items-center justify-center p-8 border border-dashed border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                                    <svg class="h-10 w-10 text-gray-400 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4zM3 6h18M16 10a4 4 0 0 1-8 0"/></svg>
                                    <p class="text-sm font-medium">No products added yet</p>
                                    <p class="text-xs mt-1">Click “Add Product” to start building the order</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Method</h2>

                        @php $pm = old('payment.method', isset($order->payment) ? $order->payment->method : ''); @endphp
                        <div class="grid grid-cols-2 gap-4" x-data="{ selectedMethod: @js($pm) }">
                            <label class="relative block cursor-pointer">
                                <input type="radio" name="payment[method]" value="cash" x-model="selectedMethod"
                                       class="absolute top-3 right-3 h-5 w-5 text-violet-600 border-gray-300 focus:ring-violet-500">
                                <div class="p-4 rounded-xl border-2 transition h-full"
                                     :class="selectedMethod==='cash' ? 'border-violet-600 bg-violet-50 shadow-md' : 'border-gray-300 hover:border-violet-400 bg-white'">
                                    <div class="p-2 w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H7M17 19H7M19 9h-2M5 9h2M19 15h-2M5 15h2"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800">Cash</p>
                                </div>
                            </label>

                            <label class="relative block cursor-pointer">
                                <input type="radio" name="payment[method]" value="gcash" x-model="selectedMethod"
                                       class="absolute top-3 right-3 h-5 w-5 text-violet-600 border-gray-300 focus:ring-violet-500">
                                <div class="p-4 rounded-xl border-2 transition h-full"
                                     :class="selectedMethod==='gcash' ? 'border-violet-600 bg-violet-50 shadow-md' : 'border-gray-300 hover:border-violet-400 bg-white'">
                                    <div class="p-2 w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mb-2">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path fill="#fff" d="M12 7.5a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm0 8a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800">GCash</p>
                                </div>
                            </label>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                                <input type="number" step="0.01" min="0"
                                       name="payment[amount]"
                                       value="{{ old('payment.amount', $order->payment->amount ?? '') }}"
                                       class="w-full rounded-lg border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Leave blank to default to Grand Total.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provider Ref (GCash)</label>
                                <input type="text" name="payment[provider_ref]"
                                       value="{{ old('payment.provider_ref', $order->payment->provider_ref ?? '') }}"
                                       class="w-full rounded-lg border-gray-300" placeholder="GCash Ref #">
                            </div>

                            <div class="md:col-span-1 flex items-end">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" name="mark_paid_now" class="rounded border-gray-300"
                                           @checked(old('mark_paid_now', false))>
                                    Mark paid now (cash)
                                </label>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Receipt Image (GCash)</label>
                                <input type="file" name="payment[receipt_image]" accept="image/*"
                                       class="w-full rounded-lg border-gray-300">
                                @if(isset($order->payment) && $order->payment->receipt_image_url)
                                    <div class="mt-2">
                                        <a href="{{ $order->payment->receipt_image_url }}" class="text-sm text-blue-600 hover:underline" target="_blank">
                                            View uploaded receipt
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Notes</h2>
                        <textarea name="notes" rows="3"
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-violet-500 focus:border-violet-500">{{ old('notes', $order->notes ?? '') }}</textarea>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Transaction Summary</h2>

                    <div class="space-y-3 mb-6 border-b pb-4">
                        <template x-for="(item, index) in orderItems" :key="index">
                            <div class="flex justify-between items-start text-sm">
                                <span class="text-gray-700 leading-tight" x-text="item.name"></span>
                                <div class="text-right flex-shrink-0 ml-4">
                                    <span class="text-gray-500 text-xs" x-text="(item.quantity||0) + ' x ₱' + Number(item.unit_price||0).toFixed(2)"></span>
                                    <p class="font-medium text-gray-900" x-text="'₱' + (Number(item.unit_price||0) * Number(item.quantity||0)).toFixed(2)"></p>
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
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Tax (12%)</span>
                            <span x-text="'₱' + taxAmount().toFixed(2)">₱0.00</span>
                        </div>
                        <hr class="my-2 border-gray-200">
                        <div class="flex justify-between font-bold text-lg text-gray-900">
                            <span>Total</span>
                            <span x-text="'₱' + grandTotal().toFixed(2)">₱0.00</span>
                        </div>
                    </div>

                    <input type="hidden" name="grand_total" x-bind:value="grandTotal().toFixed(2)">
                    <input type="hidden" name="subtotal" x-bind:value="subtotal().toFixed(2)">
                    <input type="hidden" name="tax_amount" x-bind:value="taxAmount().toFixed(2)">
                </div>
            </div>
        </div>
            @include('admin.partials.select-product-modal')
    </div>


</x-admin-layout>
