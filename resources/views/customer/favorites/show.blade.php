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
            height: 280px;
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

    <div x-data="favoritesPage()" x-init="init()" class="py-12">
        <div class="w-full max-w-none px-4 sm:px-6 lg:px-8 mx-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        My Favorites ❤️
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        All products you’ve added to favorites.
                    </p>
                </div>

                <a href="{{ route('customer.shop') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 smooth-transition shadow-sm">
                    Back to Shop
                </a>
            </div>

            {{-- Favorites Grid --}}
            @if($favorites->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                    @foreach($favorites as $favorite)
                        @php $product = $favorite->product; @endphp
                        @if (! $product)
                            @continue
                        @endif

                        <div class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-2xl smooth-transition overflow-hidden border border-gray-200 dark:border-gray-700">

                            {{-- IMAGE --}}
                            <div class="relative overflow-hidden bg-gray-100 dark:bg-gray-700 cursor-pointer"
                                 @click="openProductModal(@js($product))">

                                @if($product->image_url)
                                    <img src="{{ asset('storage/' . $product->image_url) }}"
                                         class="product-image group-hover:scale-105 smooth-transition"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="product-image flex items-center justify-center bg-gray-200 dark:bg-gray-600">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Category --}}
                                @if($product->category)
                                    <span class="absolute top-3 left-3 px-3 py-1 bg-black/80 text-white text-xs rounded-full font-medium">
                                        {{ $product->category->name }}
                                    </span>
                                @endif

                                {{-- Stock badge --}}
                                <span class="absolute bottom-3 left-3 px-2 py-1 rounded-full text-xs
                                    {{ $product->stock > 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </div>

                            {{-- PRODUCT INFO --}}
                            <div class="p-6 flex-1">
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-1 cursor-pointer text-lg mb-2"
                                        @click="openProductModal(@js($product))">
                                        {{ $product->name }}
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
                                        {{ $product->description }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                                        ₱{{ number_format($product->price, 2) }}
                                    </span>

                                    <div class="flex gap-2 items-center">
                                        @if($product->unit)
                                            <span class="text-sm text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                                {{ $product->unit }}
                                            </span>
                                        @endif

                                        @if($product->stock > 0)
                                            <span class="text-sm text-green-600 bg-green-100 dark:bg-green-900 px-2 py-1 rounded">
                                                {{ $product->stock }} in stock
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="flex gap-3">
                                    {{-- TOGGLE CART --}}
                                    <button
                                        type="button"
                                        class="cart-btn flex-1 px-4 py-3 rounded-xl font-medium shadow-sm smooth-transition
                                               bg-indigo-600 text-white hover:bg-indigo-700"
                                        data-id="{{ $product->id }}"
                                        x-text="isInCart({{ $product->id }}) ? 'Remove from Cart' : 'Add to Cart'">
                                    </button>

                                    {{-- FAVORITE TOGGLE (remove from favorites) --}}
                                    <form action="{{ route('customer.favorites.toggle', $product) }}"
                                          method="POST"
                                          class="favorite-form">
                                        @csrf
                                        <button type="submit"
                                            class="w-12 h-12 flex items-center justify-center rounded-xl shadow-sm smooth-transition
                                                   bg-red-500 text-white hover:bg-red-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                @if($favorites->hasPages())
                    <div class="mt-16 flex justify-center">
                        <div class="flex items-center gap-2">
                            {{ $favorites->links() }}
                        </div>
                    </div>
                @endif
            @else
                {{-- EMPTY STATE --}}
                <div class="col-span-full text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 016.364-6.364L12 3.293l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No favorites yet</h3>

                        <p class="text-gray-500 dark:text-gray-400 mb-6">
                            Tap the heart icon on any product in the shop to save it here.
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

                            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t">
                                <div class="flex gap-3">
                                    <button
                                        class="cart-btn flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl"
                                        :data-id="selectedProduct.id">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>

                        </div>
                    </template>

                </div>

            </div>
        </div>

    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function favoritesPage() {
            return {
                productModalOpen: false,
                selectedProduct: null,

                // initial cart contents from session (list of product IDs)
                inCartIds: @json($inCartIds ?? []),

                init() {
                    this.initCartButtons();
                },

                isInCart(id) {
                    id = Number(id);
                    return this.inCartIds.includes(id);
                },

                setInCart(id, inCart) {
                    id = Number(id);

                    if (inCart) {
                        if (!this.inCartIds.includes(id)) {
                            this.inCartIds.push(id);
                        }
                    } else {
                        this.inCartIds = this.inCartIds.filter(x => x !== id);
                    }

                    // Update all buttons for that product
                    document.querySelectorAll(`.cart-btn[data-id="${id}"]`).forEach(btn => {
                        btn.textContent = inCart ? 'Remove from Cart' : 'Add to Cart';
                    });
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

                    button.disabled = true;
                    const originalText = button.textContent;
                    button.textContent = 'Processing...';

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
                                button.textContent = originalText;
                                return;
                            }

                            if (data.status === 'added') {
                                this.setInCart(productId, true);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Added to cart!',
                                    text: data.message || 'Product added successfully.',
                                    confirmButtonText: 'OK',
                                });
                            } else if (data.status === 'removed') {
                                this.setInCart(productId, false);
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Removed from cart',
                                    text: data.message || 'Product removed from cart.',
                                    confirmButtonText: 'OK',
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Unable to update cart.',
                                confirmButtonText: 'OK',
                            });
                            button.textContent = originalText;
                        })
                        .finally(() => {
                            button.disabled = false;
                            if (!this.isInCart(productId)) {
                                button.textContent = 'Add to Cart';
                            } else {
                                button.textContent = 'Remove from Cart';
                            }
                        });
                },
            }
        }
    </script>
</x-app-layout>
