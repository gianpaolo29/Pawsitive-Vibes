<x-app-layout>

    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @auth
            <h1 class="page-title text-center mt-6 text-4xl font-extrabold text-gray-900 tracking-tight">
                Welcome Back, {{ Auth::user()->fname ?? Auth::user()->name }}! 🐾
            </h1>
            <p class="page-subtitle text-center text-gray-500 max-w-xl mx-auto mt-3 text-lg">
                Discover premium pet products that bring joy to your furry friends.
            </p>
        @else
            <h1 class="page-title text-center mt-6 text-4xl font-extrabold text-gray-900 tracking-tight">
                Welcome to Pawsitive Vibes! 🐾
            </h1>
            <p class="page-subtitle text-center text-gray-500 max-w-xl mx-auto mt-3 text-lg">
                Sign in to see personalized recommendations for your pets.
            </p>
        @endauth

    </div>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


        <hr class="my-10">

        {{-- ============================= --}}
        {{-- CATEGORIES - SINGLE LINE SCROLL (Centered) --}}
        {{-- ============================= --}}
        <section class="categories-section mt-6">
            <h2 class="section-title text-2xl font-bold mb-4 text-gray-800 text-center">Shop by Pet & Product Type</h2>

            {{-- The scrolling wrapper --}}
            <div class="categories-container overflow-x-scroll whitespace-nowrap hide-scrollbar pb-3">
                
                {{-- Horizontal Flex Layout --}}
                <div class="categories-flex inline-flex space-x-4 w-fit mx-auto lg:justify-center">

                    {{-- ALL CATEGORY --}}
                    <div class="category-card active flex flex-col items-center justify-center p-3 sm:p-4 rounded-xl cursor-pointer transition duration-200 shadow-md bg-purple-600 text-white transform hover:scale-105 w-24 sm:w-28 flex-shrink-0"
                        data-category="all">
                        <div class="category-icon mb-1">
                            <i class="fas fa-th-large text-xl sm:text-2xl"></i>
                        </div>
                        <h3 class="category-name text-xs sm:text-sm font-semibold whitespace-normal text-center">All Products</h3>
                    </div>

                    {{-- DB CATEGORIES --}}
                    @foreach ($categories as $cat)
                        <div class="category-card flex flex-col items-center justify-center p-3 sm:p-4 rounded-xl border border-gray-200 cursor-pointer transition duration-200 group hover:bg-purple-100 hover:border-purple-300 transform hover:scale-105 w-24 sm:w-28 flex-shrink-0"
                            data-category="{{ $cat->id }}">
                            <div class="category-icon mb-1 text-purple-600 group-hover:text-purple-700">
                                <i class="{{ $cat->icon ?? 'fas fa-paw' }} text-xl sm:text-2xl"></i>
                            </div>
                            <h3 class="category-name text-xs sm:text-sm font-medium text-gray-700 group-hover:text-gray-900 whitespace-normal text-center">
                                {{ $cat->name }}</h3>
                        </div>
                    @endforeach

                </div>
            </div>
            
            <style>
                /* CSS is necessary to hide the scrollbar and override Tailwind for large-screen centering */
                .hide-scrollbar::-webkit-scrollbar {
                    display: none;
                }
                .hide-scrollbar {
                    -ms-overflow-style: none;
                    scrollbar-width: none;
                }
                @media (min-width: 1024px) {
                    .categories-container {
                        display: flex;
                        justify-content: center;
                    }
                }
            </style>
        </section>


        <hr class="my-10">

        <section class="donation-section my-16">
            <div class="bg-purple-700 rounded-2xl p-8 sm:p-14 shadow-xl flex flex-col items-center relative overflow-hidden">
                {{-- Subtle background circles for visual interest, matching the reference --}}
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-purple-600 rounded-full opacity-30"></div>
                <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-purple-600 rounded-full opacity-30"></div>
                <div class="absolute top-1/2 left-1/4 w-20 h-20 bg-purple-600 rounded-full opacity-20 transform -translate-y-1/2"></div>


                <div class="donation-icon text-center text-5xl text-white z-10">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>

                <div class="donation-content text-center text-white max-w-xl mx-auto mt-4 z-0">
                    <h3 class="text-4xl font-extrabold mt-4">Support Animal Welfare</h3>
                    <p class="mt-2 text-lg opacity-95">
                        Help us provide care and shelter for abandoned and rescued animals. Your donation makes a difference in the lives of our furry friends in need.
                    </p>
                    <a href="/donate"
                        class="mt-6 inline-block bg-yellow-400 text-gray-900 px-10 py-4 font-bold rounded-full text-base shadow-lg transition duration-300 hover:bg-yellow-300 hover:shadow-2xl transform hover:scale-105">
                        <i class="fas fa-heart"></i> Donate Now
                    </a>
                </div>
            </div>
        </section>

        <hr class="my-10">
        {{-- ============================= --}}
        {{-- FEATURED PRODUCTS --}}
        {{-- ============================= --}}
        <section class="featured-section mt-16">
            <h2 class="section-title text-center text-2xl font-bold mb-8 text-gray-800">Featured Products</h2>

            <div class="featured-products grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach ($featuredProducts as $p)
                    <div
                        class="product-card bg-white rounded-xl p-5 shadow-lg border border-gray-100 transition duration-300 hover:shadow-xl transform hover:-translate-y-1 relative">
                        {{-- BADGE --}}
                        @if ($p->badge)
                            <span
                                class="product-badge absolute top-3 right-3 bg-yellow-400 text-gray-800 px-3 py-1 text-xs font-bold rounded-full shadow">
                                {{ $p->badge }}
                            </span>
                        @endif
                        {{-- IMAGE OR ICON --}}
                        <div
                            class="product-image text-center text-6xl text-purple-600 h-48 mb-4 overflow-hidden rounded-lg bg-gray-50 flex items-center justify-center">
                            @if ($p->icon)
                                <i class="{{ $p->icon }}"></i>
                            @else
                                <img src="{{ asset('storage/' . $p->image_url) }}" alt="{{ $p->name }}"
                                    class="w-full h-full object-cover transition duration-500 hover:scale-110">
                            @endif
                        </div>
                        {{-- INFO --}}
                        <div class="product-info mt-3">
                            <h3 class="product-name font-extrabold text-xl text-gray-900 truncate">{{ $p->name }}</h3>
                            <div class="product-price text-purple-600 font-bold text-xl mt-1">
                                ₱{{ number_format($p->price, 2) }}
                            </div>
                        </div>
                        {{-- ACTION --}}
                        <div class="product-actions mt-5">
                            <button
                                class="cart-btn bg-purple-600 text-white px-4 py-3 rounded-xl w-full font-semibold transition duration-200 hover:bg-purple-700 hover:shadow-md">
                                <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>

        <hr class="my-10">
        {{-- ============================= --}}
        {{-- ALL PRODUCTS --}}
        {{-- ============================= --}}
        <section class="all-products-section mt-20 pb-20">
            <h2 class="section-title text-center text-2xl font-bold mb-8 text-gray-800">Explore Our Full Range</h2>

            <div class="products-grid grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

                @foreach ($products as $item)

                    <div
                        class="product-card bg-white rounded-xl p-4 shadow-md border border-gray-100 transition duration-300 hover:shadow-lg relative">

                        {{-- BADGE --}}
                        @if ($item->badge)
                            <span
                                class="product-badge absolute top-2 left-2 bg-yellow-400 text-gray-800 px-3 py-1 text-xs font-bold rounded-full shadow">
                                {{ $item->badge }}
                            </span>
                        @endif

                        {{-- IMAGE or ICON DETECTION --}}
                        <div
                            class="product-image h-32 mb-3 overflow-hidden rounded-lg bg-gray-50 flex items-center justify-center text-purple-600 text-4xl">

                            @php
                                $icon = $item->icon;
                            @endphp

                            @if ($icon && str_contains($icon, 'fa'))
                                <i class="{{ $icon }}"></i>

                            @elseif ($item->image_url)
                                <img src="{{ asset('storage/' . $item->image_url) }}" alt="{{ $item->name }}"
                                    class="w-full h-full object-cover transition duration-500 hover:scale-110">

                            @else
                                <img src="https://placehold.co/300x300/e5e7eb/6b7280?text=No+Image" alt="No Image"
                                    class="w-full h-full object-cover rounded-lg">
                            @endif
                        </div>

                        {{-- INFO --}}
                        <div class="product-info mt-2">
                            <h3 class="product-name font-bold text-base text-gray-800 truncate">{{ $item->name }}</h3>

                            <p class="product-description text-xs text-gray-500 mt-1 h-8 overflow-hidden">
                                {{ Str::limit($item->description, 40) }}
                            </p>

                            <div class="product-price text-purple-600 font-extrabold text-lg mt-2">
                                ₱{{ number_format($item->price, 2) }}
                            </div>
                        </div>

                        {{-- ACTION --}}
                        <div class="product-actions flex gap-2 mt-4">
                            <button
                                class="favorite-btn w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 transition duration-200 hover:bg-red-100 hover:text-red-500">
                                <i class="far fa-heart text-lg"></i>
                            </button>

                            <button
                                class="cart-btn flex-1 bg-purple-600 text-white px-3 py-2 rounded-xl font-semibold text-sm transition duration-200 hover:bg-purple-700">
                                <i class="fas fa-shopping-cart mr-1"></i> Add
                            </button>
                        </div>

                    </div>

                @endforeach

            </div>
        </section>

    </div>

</x-app-layout>