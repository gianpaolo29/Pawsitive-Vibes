<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

        /* Smooth transitions */
        .ease-smooth { transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Product card */
        .product-card {
            background: #ffffff;
            border-radius: 0.875rem;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 640px) {
            .product-card { border-radius: 1.25rem; }
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12), 0 8px 20px -8px rgba(0,0,0,0.08);
        }
        .dark .product-card {
            background: #1e293b;
            border-color: rgba(255,255,255,0.06);
        }
        .dark .product-card:hover {
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.5);
        }

        /* Product image */
        .product-img-wrap { height: 180px; position: relative; overflow: hidden; }
        @media (min-width: 640px) { .product-img-wrap { height: 220px; } }
        .product-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .product-img-wrap img { transform: scale(1.08); }

        /* Image overlay gradient */
        .img-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.04) 100%);
            pointer-events: none;
        }

        /* Glassmorphism badges */
        .badge-glass {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.85);
            border: 1px solid rgba(255,255,255,0.3);
        }
        .dark .badge-glass {
            background: rgba(30,41,59,0.85);
            border-color: rgba(255,255,255,0.1);
        }

        /* Accent gradient */
        .accent-gradient { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
        .accent-gradient-warm { background: linear-gradient(135deg, #f97316, #f59e0b); }

        /* Favorite button pulse */
        .fav-btn { transition: all 0.25s ease; }
        .fav-btn:hover { transform: scale(1.15); }
        .fav-btn:active { transform: scale(0.95); }

        /* Modal image */
        .modal-product-img { width: 100%; height: 340px; object-fit: contain; background: #f8fafc; border-radius: 0.75rem; }
        .dark .modal-product-img { background: #1e293b; }

        /* Filter sidebar */
        .filter-panel {
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.06);
        }
        .dark .filter-panel {
            background: #1e293b;
            border-color: rgba(255,255,255,0.06);
        }

        /* Floating cart button */
        .float-cart {
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .float-cart:hover {
            box-shadow: 0 12px 40px rgba(99, 102, 241, 0.55);
            transform: scale(1.1);
        }

        /* Stock pill */
        .stock-pill {
            font-size: 0.65rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-weight: 700;
        }

        /* Add to cart button shine effect */
        .btn-cart {
            position: relative;
            overflow: hidden;
        }
        .btn-cart::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transform: skewX(-20deg);
            transition: left 0.5s ease;
        }
        .btn-cart:hover::after {
            left: 120%;
        }

        /* Sort select */
        .sort-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
        }
    </style>

    {{-- Toast Notifications --}}
    @foreach (['success', 'error'] as $type)
        @if (session($type))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed top-5 right-5 z-[60] flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-2xl text-white text-sm font-medium
                        {{ $type === 'success' ? 'bg-emerald-500' : 'bg-red-500' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    @if($type === 'success')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @endif
                </svg>
                {{ session($type) }}
            </div>
        @endif
    @endforeach

    <div x-data="shop()" x-init="init()" class="min-h-screen bg-gray-50/50 dark:bg-gray-950">

        {{-- PAGE HEADER --}}
        <div class="bg-gradient-to-r from-indigo-600 to-violet-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-base font-semibold text-white">Browse Shop</h1>
                    <p class="text-indigo-200 text-xs">Find everything your furry friend needs</p>
                </div>
                <div class="hidden lg:block">
                    <select x-model="sort" @change="applyFilters()"
                            class="sort-select bg-white/15 backdrop-blur-md text-white border border-white/20 rounded-lg px-3 py-1.5 text-xs font-medium focus:ring-2 focus:ring-white/30 focus:border-transparent cursor-pointer">
                        <option value="newest" class="text-gray-900">Newest</option>
                        <option value="price-low" class="text-gray-900">Price: Low to High</option>
                        <option value="price-high" class="text-gray-900">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Mobile Controls --}}
            <div class="lg:hidden flex items-center gap-2 mb-4">
                <button @click="openFilters = !openFilters"
                        class="flex items-center justify-center gap-1.5 px-3 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-sm text-xs font-semibold text-gray-700 dark:text-gray-200 ease-smooth">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                    Filters
                </button>
                <select x-model="sort" @change="applyFilters()"
                        class="sort-select px-3 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg shadow-sm text-xs font-semibold text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500">
                    <option value="newest">Newest</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                </select>
            </div>

            <div class="flex gap-8">

                {{-- FILTER SIDEBAR --}}
                <aside class="hidden lg:block w-72 flex-shrink-0">
                    <div class="filter-panel rounded-2xl shadow-sm p-6 sticky top-24">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                                Filters
                            </h3>
                            <button @click="clearFilters()" class="text-xs text-indigo-500 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold ease-smooth">
                                Reset
                            </button>
                        </div>

                        <form method="GET" action="{{ route('customer.shop') }}" id="filterForm">
                            <input type="hidden" name="sort" x-model="sort">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            {{-- Price Range --}}
                            <div class="mb-6">
                                <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Price Range</h4>
                                <div class="flex gap-2">
                                    <div class="relative flex-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-medium">₱</span>
                                        <input type="number" name="min_price" x-model="filters.min_price" placeholder="Min"
                                               class="w-full pl-7 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    </div>
                                    <span class="self-center text-gray-300 dark:text-gray-600">—</span>
                                    <div class="relative flex-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-medium">₱</span>
                                        <input type="number" name="max_price" x-model="filters.max_price" placeholder="Max"
                                               class="w-full pl-7 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-600 dark:bg-slate-800 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            {{-- Categories --}}
                            <div class="mb-6">
                                <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Categories</h4>
                                <div class="space-y-1 max-h-56 overflow-y-auto no-scrollbar">
                                    @php $selectedCats = (array) request('category', []); @endphp
                                    @forelse ($categories as $cat)
                                        <label class="flex items-center gap-3 py-2 px-3 cursor-pointer rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-700/60 ease-smooth group">
                                            <input type="checkbox" name="category[]" value="{{ $cat->id }}" x-model="filters.categories"
                                                   @checked(in_array($cat->id, $selectedCats))
                                                   class="rounded-md border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-700 w-4 h-4">
                                            <span class="text-sm text-gray-600 dark:text-gray-300 font-medium group-hover:text-indigo-600 dark:group-hover:text-indigo-400 ease-smooth">{{ $cat->name }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-400 py-2">No categories found.</p>
                                    @endforelse
                                </div>
                            </div>

                            <button type="submit" class="w-full accent-gradient text-white py-3 rounded-xl text-sm font-bold hover:opacity-90 ease-smooth shadow-lg shadow-indigo-500/20">
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </aside>

                {{-- PRODUCT GRID --}}
                <main class="flex-1 min-w-0">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5">
                            @foreach($products as $product)
                                @php
                                    $cartItemId = $cartItemIdsByProduct[$product->id] ?? null;
                                    $isInCart = !is_null($cartItemId);
                                    $isFavorited = in_array($product->id, $favoritedProductIds);
                                @endphp

                                <div class="product-card flex flex-col">
                                    {{-- Image --}}
                                    <div class="product-img-wrap cursor-pointer" @click="openProductModal(@js($product))">
                                        @if($product->image_url)
                                            <img src="{{ str_starts_with($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url) }}"
                                                 alt="{{ $product->name }}" loading="lazy">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-slate-800">
                                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="img-overlay"></div>

                                        {{-- Category Badge --}}
                                        @if($product->category)
                                            <span class="absolute top-2 left-2 sm:top-3 sm:left-3 badge-glass px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md sm:rounded-lg text-[0.55rem] sm:text-[0.65rem] font-bold text-gray-700 dark:text-gray-200 shadow-sm">
                                                {{ $product->category->name }}
                                            </span>
                                        @endif

                                        {{-- Favorite Button --}}
                                        <button @click.stop="toggleFavorite({{ $product->id }})"
                                                class="fav-btn absolute top-2 right-2 sm:top-3 sm:right-3 w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-full shadow-md ease-smooth"
                                                :class="favorites.includes({{ $product->id }}) ? 'bg-red-500 text-white' : 'badge-glass text-gray-500 dark:text-gray-300 hover:text-red-500'">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" :fill="favorites.includes({{ $product->id }}) ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                            </svg>
                                        </button>

                                        {{-- Stock Badge --}}
                                        <span class="absolute bottom-2 right-2 sm:bottom-3 sm:right-3 stock-pill px-1.5 sm:px-2 py-0.5 rounded-full shadow-sm
                                            {{ $product->stock > 0 ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                                            {{ $product->stock > 0 ? 'In Stock' : 'Sold Out' }}
                                        </span>
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="p-3 sm:p-4 flex-1 flex flex-col">
                                        <h3 class="font-bold text-gray-900 dark:text-white text-xs sm:text-sm line-clamp-1 cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 ease-smooth"
                                            @click="openProductModal(@js($product))">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-[0.65rem] sm:text-xs text-gray-400 dark:text-gray-500 line-clamp-2 mt-1 leading-relaxed flex-1 hidden sm:block">{{ $product->description }}</p>

                                        <div class="mt-2 sm:mt-3 space-y-2 sm:space-y-3">
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-base sm:text-xl font-extrabold text-gray-900 dark:text-white">
                                                    ₱{{ number_format($product->price, 2) }}
                                                </span>
                                                @if($product->unit)
                                                    <span class="text-[0.5rem] sm:text-[0.6rem] text-gray-400 dark:text-gray-500 font-medium">
                                                        / {{ $product->unit }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Add to Cart Button --}}
                                            <button @click="addToCart({{ $product->id }})" @if($product->stock <= 0) disabled @endif
                                                    class="btn-cart w-full flex items-center justify-center gap-1 sm:gap-1.5 rounded-lg sm:rounded-xl text-white text-[0.65rem] sm:text-xs font-semibold py-2 sm:py-2.5 ease-smooth shadow-md
                                                    {{ $product->stock > 0 ? 'accent-gradient hover:shadow-lg hover:shadow-indigo-500/25' : 'bg-gray-300 dark:bg-slate-600 cursor-not-allowed' }}">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-20">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300 dark:text-slate-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No products found</h3>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Try adjusting your filters to find what you're looking for.</p>
                            @if(request('search') || request('category') || request('min_price') || request('max_price'))
                                <a href="{{ route('customer.shop') }}"
                                   class="inline-flex items-center gap-2 px-5 py-2.5 accent-gradient text-white rounded-xl text-sm font-bold hover:opacity-90 ease-smooth shadow-lg shadow-indigo-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    @endif

                    {{-- Pagination --}}
                    @if($products->hasPages())
                        <div class="mt-12 flex justify-center">{{ $products->links() }}</div>
                    @endif
                </main>
            </div>
        </div>

        {{-- MOBILE FILTER DRAWER --}}
        <div x-show="openFilters" class="lg:hidden" x-cloak>
            <div x-show="openFilters" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40" @click="openFilters = false"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div x-show="openFilters"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                 class="fixed top-0 right-0 h-full w-full max-w-xs bg-white dark:bg-slate-900 shadow-2xl z-50 overflow-y-auto no-scrollbar">

                <div class="flex items-center justify-between p-5 border-b border-gray-100 dark:border-slate-800">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Filters</h3>
                    <button @click="openFilters = false" class="p-2 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg ease-smooth">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-5">
                    <form method="GET" action="{{ route('customer.shop') }}" id="mobileFilterForm">
                        <input type="hidden" name="sort" x-model="sort">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <div class="space-y-6">
                            {{-- Price --}}
                            <div>
                                <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Price Range</h4>
                                <div class="flex gap-2">
                                    <div class="relative flex-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">₱</span>
                                        <input type="number" name="min_price" x-model="filters.min_price" placeholder="Min"
                                               class="w-full pl-7 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-700 dark:bg-slate-800 rounded-lg">
                                    </div>
                                    <span class="self-center text-gray-300">—</span>
                                    <div class="relative flex-1">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">₱</span>
                                        <input type="number" name="max_price" x-model="filters.max_price" placeholder="Max"
                                               class="w-full pl-7 pr-3 py-2.5 text-sm border border-gray-200 dark:border-slate-700 dark:bg-slate-800 rounded-lg">
                                    </div>
                                </div>
                            </div>

                            {{-- Categories --}}
                            <div>
                                <h4 class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Categories</h4>
                                <div class="space-y-1 max-h-56 overflow-y-auto no-scrollbar">
                                    @foreach ($categories as $cat)
                                        <label class="flex items-center gap-3 py-2 px-3 cursor-pointer rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 ease-smooth">
                                            <input type="checkbox" name="category[]" value="{{ $cat->id }}" x-model="filters.categories"
                                                   @checked(in_array($cat->id, request('category', [])))
                                                   class="rounded-md border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-700 w-4 h-4">
                                            <span class="text-sm text-gray-600 dark:text-gray-300 font-medium">{{ $cat->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" @click="openFilters = false"
                                    class="w-full accent-gradient text-white py-3 rounded-xl text-sm font-bold hover:opacity-90 ease-smooth shadow-lg shadow-indigo-500/20">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT DETAIL MODAL --}}
        <div x-show="productModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 py-8">
                <div x-show="productModalOpen" class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="productModalOpen = false"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

                <div x-show="productModalOpen"
                     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
                    <template x-if="selectedProduct">
                        <div>
                            {{-- Close --}}
                            <button @click="productModalOpen = false"
                                    class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-md text-white hover:bg-black/40 ease-smooth">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            {{-- Image --}}
                            <div class="bg-gray-50 dark:bg-slate-800 p-6">
                                <img :src="selectedProduct.image_url && selectedProduct.image_url.startsWith('http') ? selectedProduct.image_url : '/storage/' + selectedProduct.image_url"
                                     class="modal-product-img" :alt="selectedProduct.name">
                            </div>

                            {{-- Details --}}
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4 mb-4">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight" x-text="selectedProduct.name"></h3>
                                    <span :class="selectedProduct.stock > 0 ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400' : 'bg-red-50 text-red-600 dark:bg-red-950 dark:text-red-400'"
                                          class="stock-pill px-2.5 py-1 rounded-full flex-shrink-0"
                                          x-text="selectedProduct.stock > 0 ? 'In Stock' : 'Sold Out'"></span>
                                </div>

                                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-5" x-text="selectedProduct.description || 'No description available.'"></p>

                                <div class="flex items-end justify-between mb-6 pt-4 border-t border-gray-100 dark:border-slate-800">
                                    <div>
                                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium uppercase tracking-wider">Price</span>
                                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white" x-text="'₱' + Number(selectedProduct.price).toFixed(2)"></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium uppercase tracking-wider">Available</span>
                                        <p class="text-lg font-bold" :class="selectedProduct.stock > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'"
                                           x-text="selectedProduct.stock > 0 ? selectedProduct.stock + ' left' : 'None'"></p>
                                    </div>
                                </div>

                                {{-- Modal Add to Cart --}}
                                <button @click="addToCart(selectedProduct.id)"
                                        class="btn-cart w-full flex items-center justify-center gap-2 py-3.5 accent-gradient text-white rounded-xl text-sm font-bold hover:opacity-90 ease-smooth shadow-lg shadow-indigo-500/25">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                    </svg>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- FLOATING CART BUTTON --}}
        <a href="{{ route('customer.cart.index') }}"
           class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-2xl accent-gradient text-white float-cart"
           title="Go to Cart">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
            </svg>
            <span x-show="cartCount > 0"
                  x-text="cartCount > 99 ? '99+' : cartCount"
                  class="absolute -top-1 -right-1 sm:-top-1.5 sm:-right-1.5 flex items-center justify-center min-w-[18px] h-[18px] sm:min-w-[22px] sm:h-[22px] px-1 text-[10px] sm:text-[11px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white shadow-sm"></span>
        </a>

        {{-- Toast --}}
        <div x-show="toast" x-cloak
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-5 right-5 z-[60] flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-2xl text-white text-sm font-medium bg-emerald-500">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-text="toast"></span>
        </div>
    </div>

    <script>
    function shop() {
        return {
            productModalOpen: false,
            openFilters: false,
            selectedProduct: null,
            searchQuery: '{{ request('search', '') }}',
            sort: '{{ request('sort', 'newest') }}',
            cartCount: {{ $cartItemCount }},
            favorites: @json($favoritedProductIds),
            toast: '',

            filters: {
                min_price: '{{ request('min_price', '') }}',
                max_price: '{{ request('max_price', '') }}',
                categories: @json(request('category', [])),
            },

            init() {
                this.filters.categories = this.filters.categories.map(String);
            },

            openProductModal(product) {
                this.selectedProduct = product;
                this.productModalOpen = true;
            },

            async addToCart(productId) {
                try {
                    const res = await fetch('{{ url('/customer/cart') }}/' + productId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ quantity: 1 }),
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.cartCount = data.cartCount;
                        this.showToast('Added to cart!');
                    }
                } catch (e) {}
            },

            async toggleFavorite(productId) {
                try {
                    const res = await fetch('{{ url('/customer/favorites') }}/' + productId + '/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    });
                    if (res.ok) {
                        const data = await res.json();
                        if (data.favorited) {
                            this.favorites.push(productId);
                        } else {
                            this.favorites = this.favorites.filter(id => id !== productId);
                        }
                        this.showToast(data.message);
                    }
                } catch (e) {}
            },

            showToast(msg) {
                this.toast = msg;
                setTimeout(() => this.toast = '', 2000);
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
