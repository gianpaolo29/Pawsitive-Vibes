<x-app-layout>
    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .line-clamp-1 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; }
        .line-clamp-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

        .ease-smooth { transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); }

        .product-card {
            background: #ffffff;
            border-radius: 1.25rem;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.12), 0 8px 20px -8px rgba(0,0,0,0.08);
        }
        .dark .product-card { background: #1e293b; border-color: rgba(255,255,255,0.06); }
        .dark .product-card:hover { box-shadow: 0 20px 40px -12px rgba(0,0,0,0.5); }

        .product-img-wrap { height: 220px; position: relative; overflow: hidden; }
        .product-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .product-img-wrap img { transform: scale(1.08); }

        .img-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.04) 100%);
            pointer-events: none;
        }

        .badge-glass {
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.3);
        }
        .dark .badge-glass { background: rgba(30,41,59,0.85); border-color: rgba(255,255,255,0.1); }

        .accent-gradient { background: linear-gradient(135deg, #6366f1, #8b5cf6); }

        .fav-btn { transition: all 0.25s ease; }
        .fav-btn:hover { transform: scale(1.15); }
        .fav-btn:active { transform: scale(0.95); }

        .modal-product-img { width: 100%; height: 340px; object-fit: contain; background: #f8fafc; border-radius: 0.75rem; }
        .dark .modal-product-img { background: #1e293b; }

        .stock-pill { font-size: 0.65rem; letter-spacing: 0.05em; text-transform: uppercase; font-weight: 700; }

        .btn-cart { position: relative; overflow: hidden; }
        .btn-cart::after {
            content: ''; position: absolute; top: -50%; left: -60%; width: 30%; height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transform: skewX(-20deg); transition: left 0.5s ease;
        }
        .btn-cart:hover::after { left: 120%; }
    </style>

    <div x-data="favoritesPage()" class="min-h-screen bg-gray-50/50 dark:bg-gray-950">

        {{-- PAGE HEADER --}}
        <div class="bg-gradient-to-r from-rose-500 to-pink-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-base font-semibold text-white">My Favorites</h1>
                    <p class="text-rose-100 text-xs">Products you've saved for later</p>
                </div>
                <a href="{{ route('customer.shop') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white/15 backdrop-blur-md text-white border border-white/20 hover:bg-white/25 ease-smooth">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                    </svg>
                    Back to Shop
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            @if($favorites->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-5">
                    @foreach($favorites as $favorite)
                        @php $product = $favorite->product; @endphp
                        @if(!$product) @continue @endif

                        <div class="product-card flex flex-col" x-show="!removed.includes({{ $product->id }})"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95">

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

                                {{-- Category --}}
                                @if($product->category)
                                    <span class="absolute top-3 left-3 badge-glass px-2.5 py-1 rounded-lg text-[0.65rem] font-bold text-gray-700 dark:text-gray-200 shadow-sm">
                                        {{ $product->category->name }}
                                    </span>
                                @endif

                                {{-- Remove Favorite --}}
                                <button @click.stop="removeFavorite({{ $product->id }})"
                                        class="fav-btn absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full shadow-md bg-red-500 text-white hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                    </svg>
                                </button>

                                {{-- Stock --}}
                                <span class="absolute bottom-3 right-3 stock-pill px-2 py-0.5 rounded-full shadow-sm
                                    {{ $product->stock > 0 ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Sold Out' }}
                                </span>
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4 flex-1 flex flex-col">
                                <h3 class="font-bold text-gray-900 dark:text-white text-sm line-clamp-1 cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 ease-smooth"
                                    @click="openProductModal(@js($product))">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500 line-clamp-2 mt-1 leading-relaxed flex-1">{{ $product->description }}</p>

                                <div class="mt-3 space-y-3">
                                    <div class="flex items-baseline gap-1.5">
                                        <span class="text-lg sm:text-xl font-extrabold text-gray-900 dark:text-white">
                                            ₱{{ number_format($product->price, 2) }}
                                        </span>
                                        @if($product->unit)
                                            <span class="text-[0.6rem] text-gray-400 dark:text-gray-500 font-medium">/ {{ $product->unit }}</span>
                                        @endif
                                    </div>

                                    {{-- Add to Cart --}}
                                    <button @click="addToCart({{ $product->id }})" @if($product->stock <= 0) disabled @endif
                                            class="btn-cart w-full flex items-center justify-center gap-1.5 rounded-xl text-white text-xs font-semibold py-2.5 ease-smooth shadow-md
                                            {{ $product->stock > 0 ? 'accent-gradient hover:shadow-lg hover:shadow-indigo-500/25' : 'bg-gray-300 dark:bg-slate-600 cursor-not-allowed' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($favorites->hasPages())
                    <div class="mt-12 flex justify-center">{{ $favorites->links() }}</div>
                @endif
            @else
                {{-- Empty State --}}
                <div class="text-center py-20">
                    <div class="w-20 h-20 mx-auto mb-6 bg-rose-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-rose-300 dark:text-slate-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No favorites yet</h3>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Tap the heart icon on any product to save it here.</p>
                    <a href="{{ route('customer.shop') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 accent-gradient text-white rounded-xl text-sm font-bold hover:opacity-90 ease-smooth shadow-lg shadow-indigo-500/20">
                        Browse Products
                    </a>
                </div>
            @endif
        </div>

        {{-- PRODUCT MODAL --}}
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
                            <button @click="productModalOpen = false"
                                    class="absolute top-4 right-4 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-black/20 backdrop-blur-md text-white hover:bg-black/40 ease-smooth">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>

                            <div class="bg-gray-50 dark:bg-slate-800 p-6">
                                <img :src="selectedProduct.image_url && selectedProduct.image_url.startsWith('http') ? selectedProduct.image_url : '/storage/' + selectedProduct.image_url"
                                     class="modal-product-img" :alt="selectedProduct.name">
                            </div>

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

        {{-- Toast --}}
        <div x-show="toast" x-cloak
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-5 right-5 z-[60] flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-2xl text-white text-sm font-medium"
             :class="toastType === 'success' ? 'bg-emerald-500' : 'bg-rose-500'">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-text="toast"></span>
        </div>
    </div>

    <script>
    function favoritesPage() {
        return {
            productModalOpen: false,
            selectedProduct: null,
            removed: [],
            toast: '',
            toastType: 'success',

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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ quantity: 1 }),
                    });
                    if (res.ok) {
                        this.showToast('Added to cart!', 'success');
                    }
                } catch (e) {}
            },

            async removeFavorite(productId) {
                try {
                    const res = await fetch('{{ url('/customer/favorites') }}/' + productId + '/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                    });
                    if (res.ok) {
                        this.removed.push(productId);
                        this.showToast('Removed from favorites.', 'info');
                    }
                } catch (e) {}
            },

            showToast(msg, type = 'success') {
                this.toastType = type;
                this.toast = msg;
                setTimeout(() => this.toast = '', 2000);
            },
        }
    }
    </script>
</x-app-layout>
