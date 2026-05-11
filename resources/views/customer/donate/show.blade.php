<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-violet-50/30 py-8 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">

            {{-- HERO HEADER --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl shadow-lg shadow-violet-200 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Make a Donation</h1>
                <p class="text-gray-500 mt-2 text-sm sm:text-base max-w-md mx-auto">Your generosity helps rescued and stray animals find a better life.</p>
            </div>

            <form
                action="{{ route('customer.donations.store') }}"
                method="POST"
                enctype="multipart/form-data"
                x-data="donationForm({{ $products->map(fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $p->price,
                    'image' => $p->image_url ? (str_starts_with($p->image_url, 'http') ? $p->image_url : asset('storage/'.$p->image_url)) : null,
                ])->values()->toJson() }})"
                x-cloak
                class="space-y-8"
            >
                @csrf

                {{-- ========== STEP 1: DONATION TYPE ========== --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-violet-600 text-white text-xs font-bold">1</span>
                        <h2 class="text-lg font-semibold text-gray-900">Choose Donation Type</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- PRODUCT CARD --}}
                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="products" x-model="type" class="peer hidden">
                            <div class="relative overflow-hidden border-2 rounded-2xl p-5 h-full flex flex-col gap-3 bg-white transition-all duration-300
                                        peer-checked:border-violet-500 peer-checked:shadow-lg peer-checked:shadow-violet-100
                                        border-gray-200 hover:border-violet-300 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-100 to-purple-100 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-gray-900">Product Donation</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Donate pet supplies to shelters</p>
                                    </div>
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-violet-100 text-violet-700">In-Kind</span>
                                </div>
                                {{-- Check indicator --}}
                                <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-violet-500 peer-checked:bg-violet-500 transition-all flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                </div>
                            </div>
                        </label>

                        {{-- CASH CARD --}}
                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="cash" x-model="type" class="peer hidden">
                            <div class="relative overflow-hidden border-2 rounded-2xl p-5 h-full flex flex-col gap-3 bg-white transition-all duration-300
                                        peer-checked:border-emerald-500 peer-checked:shadow-lg peer-checked:shadow-emerald-100
                                        border-gray-200 hover:border-emerald-300 hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-base font-bold text-gray-900">Cash Donation</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Send via GCash for flexibility</p>
                                    </div>
                                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-emerald-100 text-emerald-700">GCash</span>
                                </div>
                                <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- ========== STEP 2: DONATION DETAILS ========== --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-violet-600 text-white text-xs font-bold">2</span>
                        <h2 class="text-lg font-semibold text-gray-900" x-text="type === 'products' ? 'Select Products' : 'Enter Amount'"></h2>
                    </div>

                    {{-- ===== PRODUCTS SECTION ===== --}}
                    <div x-show="type === 'products'" x-transition.duration.300ms>
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                            {{-- Suggested Products --}}
                            @if($suggestedProducts->isNotEmpty())
                            <div class="p-5 bg-gradient-to-r from-violet-50 to-purple-50 border-b border-violet-100">
                                <p class="text-xs font-bold text-violet-700 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                    Quick Add - Suggested Products
                                </p>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($suggestedProducts as $sp)
                                    <button
                                        type="button"
                                        @click="suggestProduct({{ $sp->id }})"
                                        class="group flex items-center gap-3 p-3 bg-white rounded-xl border border-violet-200/60 hover:border-violet-400 hover:shadow-md transition-all duration-200 text-left"
                                    >
                                        @if($sp->image_url)
                                        <img src="{{ str_starts_with($sp->image_url, 'http') ? $sp->image_url : asset('storage/'.$sp->image_url) }}"
                                             alt="{{ $sp->name }}"
                                             class="w-10 h-10 rounded-lg object-cover shrink-0 border border-gray-100">
                                        @else
                                        <div class="w-10 h-10 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-violet-700 transition-colors">{{ $sp->name }}</p>
                                            <p class="text-xs font-bold text-violet-600">₱{{ number_format($sp->price, 2) }}</p>
                                        </div>
                                        <div class="w-6 h-6 rounded-full bg-violet-100 group-hover:bg-violet-500 flex items-center justify-center transition-colors shrink-0">
                                            <svg class="w-3.5 h-3.5 text-violet-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                        </div>
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            {{-- Product List --}}
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-sm font-semibold text-gray-700">Your Donation Items</p>
                                    <button type="button" @click="addItem()"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-violet-600 text-white text-xs font-semibold hover:bg-violet-700 shadow-sm hover:shadow-md transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                        Add Product
                                    </button>
                                </div>

                                <div class="space-y-3">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="group relative flex flex-col sm:flex-row sm:items-center gap-3 p-4 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-white hover:border-violet-200 hover:shadow-sm transition-all duration-200">
                                            {{-- Product image preview --}}
                                            <div class="w-12 h-12 rounded-xl overflow-hidden border border-gray-200 bg-white shrink-0 hidden sm:block">
                                                <template x-if="findProduct(item.product_id)?.image">
                                                    <img :src="findProduct(item.product_id).image" class="w-full h-full object-cover">
                                                </template>
                                                <template x-if="!findProduct(item.product_id)?.image">
                                                    <div class="w-full h-full flex items-center justify-center bg-violet-50">
                                                        <svg class="w-5 h-5 text-violet-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                    </div>
                                                </template>
                                            </div>

                                            {{-- Product select --}}
                                            <div class="flex-1">
                                                <select class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                                                        x-model="item.product_id"
                                                        :name="`products[${index}][product_id]`"
                                                        :required="type === 'products'">
                                                    <option value="">Select a product...</option>
                                                    <template x-for="product in allProducts" :key="product.id">
                                                        <option :value="product.id" x-text="`${product.name} — ₱${Number(product.price).toLocaleString('en-PH', {minimumFractionDigits: 2})}`"></option>
                                                    </template>
                                                </select>
                                            </div>

                                            {{-- Quantity --}}
                                            <div class="flex items-center gap-2 shrink-0">
                                                <button type="button" @click="item.quantity = Math.max(1, item.quantity - 1)"
                                                        class="w-8 h-8 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 flex items-center justify-center transition">
                                                    <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/></svg>
                                                </button>
                                                <input type="number" min="1"
                                                       class="w-14 text-center border border-gray-300 rounded-xl py-2 text-sm font-semibold bg-white focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                                                       x-model.number="item.quantity"
                                                       :name="`products[${index}][quantity]`"
                                                       :required="type === 'products'">
                                                <button type="button" @click="item.quantity++"
                                                        class="w-8 h-8 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 flex items-center justify-center transition">
                                                    <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                                </button>
                                            </div>

                                            {{-- Line total --}}
                                            <div class="text-right sm:w-28 shrink-0">
                                                <p class="text-xs text-gray-500">Subtotal</p>
                                                <p class="text-sm font-bold text-gray-900">₱ <span x-text="lineTotal(item).toLocaleString('en-PH', {minimumFractionDigits: 2})"></span></p>
                                            </div>

                                            {{-- Remove --}}
                                            <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                                    class="absolute top-2 right-2 sm:static w-7 h-7 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                {{-- Total --}}
                                <div class="mt-5 pt-4 border-t border-gray-200 flex items-center justify-between">
                                    <p class="text-sm text-gray-500">Estimated Total Value</p>
                                    <p class="text-2xl font-bold text-violet-700">₱ <span x-text="total.toLocaleString('en-PH', {minimumFractionDigits: 2})"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== CASH SECTION ===== --}}
                    <div x-show="type === 'cash'" x-transition.duration.300ms x-data="{ cashAmount: '' }">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                            {{-- Suggested amounts --}}
                            <div class="p-5 bg-gradient-to-r from-emerald-50 to-green-50 border-b border-emerald-100">
                                <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                    Suggested Amounts
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="amt in [50, 100, 200, 500, 1000]" :key="amt">
                                        <button type="button" @click="cashAmount = amt"
                                                :class="cashAmount == amt
                                                    ? 'border-emerald-500 bg-emerald-600 text-white shadow-md shadow-emerald-200'
                                                    : 'border-gray-200 bg-white text-gray-700 hover:border-emerald-400 hover:shadow-sm'"
                                                class="px-5 py-2.5 rounded-xl border-2 font-bold text-sm transition-all duration-200"
                                                x-text="'₱' + amt.toLocaleString()"></button>
                                    </template>
                                </div>
                            </div>

                            <div class="p-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Custom Amount (₱)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">₱</span>
                                    <input type="number" min="1" step="0.01" name="amount" x-model="cashAmount"
                                           class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl text-lg font-semibold text-gray-900 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition"
                                           placeholder="Enter amount" :required="type === 'cash'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== STEP 3: PAYMENT (QR CODE) ========== --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-violet-600 text-white text-xs font-bold">3</span>
                        <h2 class="text-lg font-semibold text-gray-900">Pay via GCash</h2>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="p-6 sm:p-8 flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center mb-4">
                                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Scan to Pay with GCash</h3>
                            <p class="text-sm text-gray-500 mb-5 max-w-xs">Open your GCash app, tap "Scan QR", and scan the code below to send your payment.</p>

                            <div class="p-3 bg-white rounded-2xl border-2 border-dashed border-blue-200 shadow-inner">
                                <img src="{{ asset('images/Gcash.jpg') }}" alt="GCash QR Code" class="w-44 h-44 sm:w-52 sm:h-52 object-contain rounded-xl">
                            </div>

                            <div class="mt-5 flex items-center gap-2 px-4 py-2.5 bg-amber-50 rounded-xl border border-amber-200">
                                <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                <p class="text-xs text-amber-800 font-medium">After payment, upload your GCash receipt below as proof.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== STEP 4: DONOR INFO & RECEIPT ========== --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-violet-600 text-white text-xs font-bold">4</span>
                        <h2 class="text-lg font-semibold text-gray-900">Your Information</h2>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                                <input type="text" name="name"
                                       value="{{ old('name', auth()->user()->fname . ' ' . auth()->user()->lname) }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 focus:bg-white transition"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                                <input type="email" name="email"
                                       value="{{ old('email', auth()->user()->email) }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 focus:bg-white transition"
                                       required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                                <input type="text" name="phone"
                                       value="{{ old('phone') }}"
                                       class="w-full border-2 border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-violet-500 focus:bg-white transition"
                                       placeholder="e.g., 09XX-XXX-XXXX"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Upload Receipt</label>
                                <input type="file" name="receipt"
                                       class="w-full text-sm text-gray-600 border-2 border-gray-200 rounded-xl px-3 py-2 bg-gray-50 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-violet-100 file:text-violet-700 hover:file:bg-violet-200 focus:outline-none focus:ring-2 focus:ring-violet-500 transition"
                                       required accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== SUBMIT ========== --}}
                <div class="flex justify-center pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-gradient-to-r from-violet-600 to-purple-600 text-white text-sm font-bold shadow-lg shadow-violet-200 hover:shadow-xl hover:shadow-violet-300 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                        Submit Donation
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Alpine Logic --}}
    <script>
        function donationForm(allProducts) {
            return {
                type: 'products',
                allProducts: allProducts,
                items: [{ product_id: '', quantity: 1 }],

                addItem() {
                    this.items.push({ product_id: '', quantity: 1 });
                },

                suggestProduct(productId) {
                    const empty = this.items.find(i => !i.product_id);
                    if (empty) {
                        empty.product_id = String(productId);
                        return;
                    }
                    const exists = this.items.find(i => i.product_id == productId);
                    if (exists) {
                        exists.quantity++;
                    } else {
                        this.items.push({ product_id: String(productId), quantity: 1 });
                    }
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
                    return product.price * (item.quantity || 0);
                },

                get total() {
                    return this.items.reduce((sum, item) => sum + this.lineTotal(item), 0);
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#7c3aed',
                showConfirmButton: false,
                timer: 3000
            });
            @endif

            @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#7c3aed',
            });
            @endif
        });
    </script>
</x-app-layout>
