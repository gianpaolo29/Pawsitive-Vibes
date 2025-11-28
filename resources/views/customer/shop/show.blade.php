<x-app-layout>
    <style>
        /* --- UTILITIES & BASE --- */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        
        /* --- STYLING --- */
        .product-image-wrapper { height: 250px; } /* Slightly reduced height for mobile friendliness */
        .product-image { width: 100%; height: 100%; object-fit: cover; object-position: center; }

        .modal-image { width: 100%; height: 320px; object-fit: contain; background: #f8fafc; }
        .dark .modal-image { background: #374151; }

        .smooth-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .gradient-bg { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); } /* Indigo theme */

        /* Card background for contrast */
        .product-card-bg { background: #ffffff; }
        .dark .product-card-bg { background: #1f2937; }
    </style>

    @if (session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 1000)" {{-- 1 second --}}
        x-show="show"
        x-transition.opacity.duration.300ms
        class="fixed top-4 right-4 z-50 px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg"
    >
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 1000)" {{-- 1 second --}}
        x-show="show"
        x-transition.opacity.duration.300ms
        class="fixed top-4 right-4 z-50 px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg"
    >
        {{ session('error') }}
    </div>
    @endif
    

    <div x-data="shop()" x-init="init()" class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-none px-4 sm:px-6 lg:px-8 mx-auto">

            {{-- Mobile Filter Button / Sort --}}
            <div class="lg:hidden flex items-center justify-between mb-8">
                <button @click="openFilters = !openFilters"
                        class="flex items-center gap-2 px-4 py-3 product-card-bg border border-gray-300 dark:border-gray-700 rounded-xl shadow-sm hover:bg-gray-100 dark:hover:bg-gray-700 smooth-transition font-medium text-gray-700 dark:text-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 10h18M3 16h18" /></svg>
                    Filters
                </button>
                <div class="relative">
                    <select x-model="sort" @change="applyFilters()"
                            class="block w-full pl-3 pr-10 py-3 text-base border border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl">
                        <option value="newest">Newest</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-8">

                {{-- FILTER SIDEBAR (Desktop) --}}
                <div class="hidden lg:block w-80 flex-shrink-0">
                    <div class="product-card-bg rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 sticky top-24">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h3>
                            <button @click="clearFilters()" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium smooth-transition">
                                Clear all
                            </button>
                        </div>

                        <form method="GET" action="{{ route('customer.shop') }}" id="filterForm">
                            <input type="hidden" name="sort" x-model="sort">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            {{-- PRICE --}}
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4 border-t pt-4">Price Range</h4>
                                <div class="flex gap-3">
                                    <input type="number" name="min_price" x-model="filters.min_price" placeholder="Min" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg">
                                    <input type="number" name="max_price" x-model="filters.max_price" placeholder="Max" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg">
                                </div>
                            </div>

                            {{-- CATEGORIES --}}
                            <div class="mb-6">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4 border-t pt-4">Categories</h4>
                                <div class="space-y-3 max-h-60 overflow-y-auto no-scrollbar">
                                    @php $selectedCats = (array) request('category', []); @endphp
                                    @forelse ($categories as $cat)
                                        <label class="flex items-center gap-3 py-2 cursor-pointer hover:bg-indigo-50/20 dark:hover:bg-gray-700 px-3 rounded-lg smooth-transition">
                                            <input type="checkbox" name="category[]" value="{{ $cat->id }}" x-model="filters.categories" @checked(in_array($cat->id, $selectedCats)) class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                            <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $cat->name }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500">No categories found.</p>
                                    @endforelse
                                </div>
                            </div>

                            {{-- APPLY --}}
                            <button type="submit" class="w-full gradient-bg text-white py-4 rounded-xl font-medium hover:opacity-90 smooth-transition shadow-lg">
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </div>

                {{-- MAIN PRODUCT CONTENT --}}
                <div class="flex-1">

                    {{-- Products Grid: FIX RESPONSIVENESS --}}
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                            @foreach($products as $product)
                                @php
                                    $cartItemId = $cartItemIdsByProduct[$product->id] ?? null;
                                    $isInCart = !is_null($cartItemId);
                                    $isFavorited = $product->is_favorite ?? false; 
                                @endphp

                                <div class="group product-card-bg rounded-2xl shadow-lg hover:shadow-2xl smooth-transition overflow-hidden border border-gray-200 dark:border-gray-700">

                                    {{-- IMAGE & BADGES --}}
                                    <div class="relative overflow-hidden bg-gray-100 dark:bg-gray-700 cursor-pointer product-image-wrapper"
                                            @click="openProductModal(@js($product))">
                                        
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}"
                                                class="product-image group-hover:scale-105 smooth-transition"
                                                alt="{{ $product->name }}">
                                        @else
                                            <div class="product-image flex items-center justify-center bg-gray-200 dark:bg-gray-600">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                        
                                        @if($product->category)
                                            <span class="absolute top-3 left-3 px-3 py-1 bg-indigo-600/90 text-white text-xs rounded-full font-medium shadow-md">
                                                {{ $product->category->name }}
                                            </span>
                                        @endif
                                        
                                        <span class="absolute bottom-3 right-3 px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $product->stock > 0 ? 'bg-green-600 text-white shadow-md' : 'bg-red-600 text-white shadow-md' }}">
                                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                    </div>

                                    {{-- PRODUCT INFO & ACTIONS --}}
                                    <div class="p-4 sm:p-6 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white line-clamp-1 cursor-pointer text-base mb-1"
                                                @click="openProductModal(@js($product))">{{ $product->name }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 h-8 mb-3">{{ $product->description }}</p>
                                        </div>

                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-xl font-extrabold text-indigo-600 dark:text-indigo-400">
                                                ₱{{ number_format($product->price, 2) }}
                                            </span>
                                            @if($product->unit)
                                                <span class="text-sm text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full">
                                                    {{ $product->unit }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- ACTION BUTTONS --}}
                                        <div class="flex gap-3">
                                            
                                            {{-- DYNAMIC ADD / REMOVE CART BUTTON --}}
                                            @if (! $isInCart)
                                                <form action="{{ route('customer.cart.store', $product->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                            @if($product->stock <= 0) disabled @endif
                                                            class="w-full inline-flex justify-center items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold smooth-transition
                                                            {{ $product->stock > 0 ? 'gradient-bg text-white hover:opacity-90 shadow-md' : 'bg-gray-400 text-white cursor-not-allowed' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l1.4-7H6.4M7 13L5.4 5M7 13l-2 6h14M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
                                                        <span>Add to Cart</span>
                                                    </button>
                                                </form>
                                            @else
                                                {{-- In cart: "Removed to Cart" (DELETE method) --}}
                                                <form action="{{ route('customer.cart.destroy', $cartItemId) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="w-full inline-flex justify-center items-center gap-2 rounded-lg border border-red-600 px-3 py-2 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/50 dark:hover:bg-red-900/80 smooth-transition shadow-md">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        <span>Remove from Cart</span>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- FAVORITE BUTTON --}}
                                            <form action="{{ route('customer.favorites.toggle', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="w-10 h-10 flex items-center justify-center rounded-xl shadow-md smooth-transition
                                                        {{ $isFavorited ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-red-500 hover:text-white' }}">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- NO PRODUCTS --}}
                        <div class="col-span-full text-center py-16 product-card-bg rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No products found</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-6">
                                    Try adjusting your filters to find what you're looking for.
                                </p>
                                @if(request('search') || request('category') || request('min_price') || request('max_price'))
                                    <a href="{{ route('customer.shop') }}" class="inline-flex items-center px-6 py-3 gradient-bg text-white rounded-xl hover:opacity-90 smooth-transition font-medium shadow-sm">
                                        Clear filters
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- PAGINATION --}}
                    @if($products->hasPages())
                        <div class="mt-16 flex justify-center">{{ $products->links() }}</div>
                    @endif
                </div>
            </div> 
        </div> 

        {{-- MOBILE FILTER DRAWER (unchanged for functionality) --}}
        <div x-show="openFilters" class="lg:hidden" x-cloak>
            <div x-show="openFilters" class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="openFilters = false"></div>
            <div x-show="openFilters"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="fixed top-0 right-0 h-full w-80 product-card-bg shadow-xl z-50 overflow-y-auto no-scrollbar">

                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h3>
                    <button @click="openFilters = false" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg smooth-transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <div class="p-6">
                    <form method="GET" action="{{ route('customer.shop') }}" id="mobileFilterForm">
                        <input type="hidden" name="sort" x-model="sort">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <div class="space-y-8">
                            <div><h4 class="font-medium text-gray-900 dark:text-white mb-4">Price Range</h4><div class="flex gap-3"><input type="number" name="min_price" x-model="filters.min_price" placeholder="Min" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"><input type="number" name="max_price" x-model="filters.max_price" placeholder="Max" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"></div></div>
                            <div><h4 class="font-medium text-gray-900 dark:text-white mb-4">Categories</h4><div class="space-y-3 max-h-60 overflow-y-auto no-scrollbar">@foreach ($categories as $cat)<label class="flex items-center gap-3 py-2 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 px-3 rounded-lg"><input type="checkbox" name="category[]" value="{{ $cat->id }}" x-model="filters.categories" @checked(in_array($cat->id, request('category', []))) class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"><span class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $cat->name }}</span></label>@endforeach</div></div>
                            <button type="submit" @click="openFilters = false" class="w-full gradient-bg text-white py-4 rounded-xl font-medium hover:opacity-90 smooth-transition shadow-sm">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT MODAL (Finalized Modal Cart Logic) --}}
        <div x-show="productModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                <div x-show="productModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="productModalOpen = false"></div>
                <div x-show="productModalOpen" class="inline-block product-card-bg rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <template x-if="selectedProduct">
                        <div>
                            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="selectedProduct.name"></h3>
                                <button @click="productModalOpen = false" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"><svg class="w-6 h-6" stroke="currentColor" fill="none"><path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
                            </div>
                            <div class="p-6">
                                <img :src="'/storage/' + selectedProduct.image_url" class="modal-image rounded-lg">
                                <div class="mt-6 space-y-4">
                                    <div><h4 class="font-medium text-gray-900 dark:text-white">Description</h4><p class="text-gray-600 dark:text-gray-400" x-text="selectedProduct.description || 'No description available'"></p></div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div><h4 class="font-medium text-gray-900 dark:text-white">Price</h4><p class="text-2xl font-bold text-indigo-600" x-text="'₱' + Number(selectedProduct.price).toFixed(2)"></p></div>
                                        <div><h4 class="font-medium text-gray-900 dark:text-white">Stock</h4><p :class="selectedProduct.stock > 0 ? 'text-green-600' : 'text-red-600'" x-text="selectedProduct.stock > 0 ? selectedProduct.stock + ' in stock' : 'Out of stock'"></p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t">
                                <div class="flex gap-3">

                                    {{-- ADD TO CART (when not in cart) --}}
                                    <template x-if="!isSelectedInCart()">
                                        <form :action="'{{ url('/customer/cart') }}/' + selectedProduct.id" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center items-center gap-2 rounded-lg px-3 py-3 text-sm font-semibold smooth-transition gradient-bg text-white hover:opacity-90 shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l1.4-7H6.4M7 13L5.4 5M7 13l-2 6h14M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" /></svg>
                                                <span>Add to Cart</span>
                                            </button>
                                        </form>
                                    </template>

                                    {{-- REMOVE FROM CART (when already in cart) --}}
                                    <template x-if="isSelectedInCart()">
                                        <form :action="'{{ url('/customer/cart/item') }}/' + selectedCartItemId()" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center items-center gap-2 rounded-lg border border-red-600 px-3 py-3 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-900/50 dark:hover:bg-red-900/80 smooth-transition shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                <span>Remove from Cart</span>
                                            </button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div> 

    {{-- SCRIPTS --}}
    <script>
    function shop() {
        return {
            productModalOpen: false,
            openFilters: false,
            selectedProduct: null,

            searchQuery: '{{ request('search', '') }}',
            sort: '{{ request('sort', 'newest') }}',
            gridView: 'grid',

            filters: {
                min_price: '{{ request('min_price', '') }}',
                max_price: '{{ request('max_price', '') }}',
                categories: @json(request('category', [])),
            },

            // 🔹 Data passed from PHP (product_id => cart_item_id)
            cartMap: @json($cartItemIdsByProduct ?? []),

            init() {
                this.filters.categories = this.filters.categories.map(String);
            },

            // 🔹 Check if the currently selected modal product is in the cart
            isSelectedInCart() {
                if (!this.selectedProduct) return false;
                return this.cartMap[this.selectedProduct.id] !== undefined;
            },

            // 🔹 Get the cart item ID for the currently selected modal product
            selectedCartItemId() {
                if (!this.selectedProduct) return null;
                return this.cartMap[this.selectedProduct.id] ?? null;
            },

            openProductModal(product) {
                // NOTE: We rely on the global cartMap to check cart status for the modal
                this.selectedProduct = product;
                this.productModalOpen = true;
            },

            applyFilters() {
                const form = document.getElementById('filterForm') || document.getElementById('mobileFilterForm');
                if (form) form.submit();
            },

            clearFilters() {
                window.location.href = '{{ route('customer.shop') }}';
            },
        }
    }
    </script>
</x-app-layout>