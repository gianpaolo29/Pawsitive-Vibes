<x-app-layout>
    <style>
        :root { --secondary-color: #8259E2; --accent-color: #F9DF97; }
        .landing-wrapper { font-family: 'Inter', sans-serif; overflow-x: hidden; background: #f8f9fa; }
        .custom-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        
        /* Floating Animation */
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
        .animate-float { animation: float 5s ease-in-out infinite; }

        /* Button Hover Glow */
        .btn-glow:hover { box-shadow: 0 0 20px rgba(130, 89, 226, 0.6); }
    </style>

    <div class="landing-wrapper">
        
        <!-- HERO SECTION -->
        <section class="hero py-16 md:py-24 relative overflow-hidden">
            <!-- Animated Blob Background -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="z-index: 0;"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 2s; z-index: 0;"></div>

            <div class="custom-container relative z-10">
                <div class="flex flex-col md:flex-row items-center gap-10">
                    
                    <!-- Text Side (Fades Right) -->
                    <div class="flex-1 text-center md:text-left" data-aos="fade-right">
                        <span class="inline-block px-4 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold mb-4">🐾 Premium Pet Care</span>
                        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 leading-tight mb-6">
                            Pawsitive Vibes <br> <span class="text-purple-600">Pet Supplies</span>
                        </h1>
                        <p class="text-lg text-gray-600 mb-8">
                            Discover a place where pets come first. Essentials, treats, and toys to support every stage of your pet's life.
                        </p>
                        <div class="flex gap-4 justify-center md:justify-start">
                            <a href="{{ route('customer.shop') }}" class="btn-glow px-8 py-4 bg-purple-600 text-white font-bold rounded-full transition transform hover:scale-105">Shop Now</a>
                            <a href="{{ route('customer.donate') }}" class="px-8 py-4 border-2 border-purple-600 text-purple-600 font-bold rounded-full transition hover:bg-purple-50">Donate</a>
                        </div>
                    </div>

                    <!-- Image Side (Fades Left with 3D Tilt) -->
                    <div class="flex-1 flex justify-center" data-aos="fade-left">
                        <div class="tilt-card relative w-full max-w-md">
                            <div class="absolute inset-0 bg-yellow-400 rounded-3xl transform rotate-6 opacity-30"></div>
                            <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=800&q=80" 
                                 class="relative rounded-3xl shadow-2xl w-full object-cover transform transition duration-500 hover:scale-105" 
                                 alt="Happy pets">
                        </div>
                    </div>
                </div>
            </div>
        </section>

{{-- ============================= --}}
        {{-- 3. CATEGORIES (Colorful & Interactive) --}}
        {{-- ============================= --}}
        <section class="py-16 md:py-24 relative z-10">
            
            {{-- Header --}}
            <div class="custom-container text-center mb-12" data-aos="fade-down">
                <span class="text-purple-600 font-extrabold tracking-widest uppercase text-xs bg-purple-100 px-4 py-2 rounded-full mb-4 inline-block shadow-sm">
                    Collections
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Browse by <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500">Category</span>
                </h2>
            </div>

            {{-- Grid Container --}}
            <div class="custom-container">
                <div class="flex flex-wrap justify-center gap-4 md:gap-8">
                    
                    @foreach($categories as $index => $cat)
                        {{-- 
                           COLOR LOGIC: 
                           Cycles through 6 different color themes based on the loop index ($index).
                           This ensures your grid looks colorful without you manually setting colors for each one.
                        --}}
                        @php
                            $themes = [
                                ['bg' => 'bg-orange-50', 'text' => 'text-orange-500', 'border' => 'border-orange-100', 'icon_bg' => 'bg-orange-100', 'hover_border' => 'hover:border-orange-300'],
                                ['bg' => 'bg-blue-50',   'text' => 'text-blue-500',   'border' => 'border-blue-100',   'icon_bg' => 'bg-blue-100',   'hover_border' => 'hover:border-blue-300'],
                                ['bg' => 'bg-green-50',  'text' => 'text-green-500',  'border' => 'border-green-100',  'icon_bg' => 'bg-green-100',  'hover_border' => 'hover:border-green-300'],
                                ['bg' => 'bg-pink-50',   'text' => 'text-pink-500',   'border' => 'border-pink-100',   'icon_bg' => 'bg-pink-100',   'hover_border' => 'hover:border-pink-300'],
                                ['bg' => 'bg-purple-50', 'text' => 'text-purple-500', 'border' => 'border-purple-100', 'icon_bg' => 'bg-purple-100', 'hover_border' => 'hover:border-purple-300'],
                                ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-100', 'icon_bg' => 'bg-yellow-100', 'hover_border' => 'hover:border-yellow-300'],
                            ];
                            $theme = $themes[$index % 6]; // Cycle through the 6 themes
                        @endphp

                        {{-- THE CARD --}}
                        <a href="{{ route('customer.shop', ['category' => $cat->id]) }}" 
                           class="tilt-card group relative w-36 md:w-48 h-40 md:h-52 {{ $theme['bg'] }} rounded-[2rem] border-2 {{ $theme['border'] }} {{ $theme['hover_border'] }} flex flex-col items-center justify-center transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl cursor-pointer overflow-hidden"
                           data-aos="zoom-in" 
                           data-aos-delay="{{ $index * 50 }}">
                            
                            {{-- Background Decoration (Faint Circle) --}}
                            <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full {{ $theme['icon_bg'] }} opacity-50 transition-transform duration-500 group-hover:scale-150"></div>

                            {{-- Icon --}}
                            <div class="relative z-10 w-14 h-14 md:w-16 md:h-16 rounded-full {{ $theme['icon_bg'] }} flex items-center justify-center mb-3 shadow-inner group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $cat->icon ?? 'fas fa-paw' }} text-2xl md:text-3xl {{ $theme['text'] }}"></i>
                            </div>

                            {{-- Name --}}
                            <h3 class="relative z-10 font-bold text-gray-800 text-sm md:text-base text-center px-2 group-hover:text-gray-900">
                                {{ $cat->name }}
                            </h3>

                            {{-- Hover Arrow (Slides up) --}}
                            <div class="absolute bottom-3 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <i class="fas fa-chevron-right {{ $theme['text'] }} text-xs"></i>
                            </div>
                        </a>

                    @endforeach
                </div>
            </div>
        </section>

        <!-- FEATURED PRODUCTS (3D Cards) -->
        <section class="py-16 bg-gray-50">
            <div class="custom-container">
                <h2 class="text-3xl font-bold text-center mb-12 text-gray-800" data-aos="fade-up">Best Sellers</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($featuredProducts as $index => $p)
                        <div class="tilt-card bg-white p-4 rounded-3xl shadow-lg border border-gray-100 relative group overflow-hidden"
                             data-aos="zoom-in" 
                             data-aos-delay="{{ $index * 100 }}">
                            
                            <!-- Image Area -->
                            <div class="h-48 bg-gray-100 rounded-2xl mb-4 flex items-center justify-center overflow-hidden">
                                @if($p->image_url)
                                    <img src="{{ asset('storage/' . $p->image_url) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <i class="{{ $p->icon ?? 'fas fa-paw' }} text-5xl text-gray-300"></i>
                                @endif
                            </div>

                            <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $p->name }}</h3>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xl font-bold text-purple-600">₱{{ number_format($p->price, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- DONATION SECTION (Parallax Effect) -->
        <section class="py-20 my-10">
            <div class="custom-container">
                <div class="tilt-card bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl p-8 md:p-12 text-white shadow-2xl flex flex-col md:flex-row items-center gap-10"
                     data-aos="flip-up">
                    
                    <div class="text-6xl text-yellow-300 animate-float">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-3xl font-bold mb-4">Support Animal Welfare</h3>
                        <p class="opacity-90 text-lg mb-6">
                            Every donation provides shelter, food, and love to animals waiting for their forever homes.
                        </p>
                        <a href="{{ route('customer.donate') }}" class="btn-glow inline-block bg-white text-purple-700 font-bold px-8 py-3 rounded-full shadow-lg transform transition hover:scale-105">
                            Donate Now
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVICES (Fade Up) -->
        <section class="py-16 bg-white">
            <div class="custom-container">
                <h2 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">Our Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="tilt-card p-8 rounded-3xl bg-blue-50 border border-blue-100 text-center" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4 shadow-lg shadow-blue-500/30">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Online Ordering</h3>
                        <p class="text-gray-600">Shop from home with our easy-to-use platform.</p>
                    </div>

                    <div class="tilt-card p-8 rounded-3xl bg-green-50 border border-green-100 text-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4 shadow-lg shadow-green-500/30">
                            <i class="fas fa-store"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800">In-store Pickup</h3>
                        <p class="text-gray-600">Ready in 30 minutes. Skip the line!</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- HOURS -->
        <section class="py-16 pb-24">
            <div class="custom-container text-center" data-aos="zoom-in-up">
                <div class="inline-block bg-yellow-100 border-2 border-yellow-200 p-8 rounded-3xl relative">
                    <div class="text-4xl text-yellow-600 mb-2 animate-bounce">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">We're Open!</h3>
                    <p class="text-3xl font-extrabold text-purple-600">9:00 AM - 8:00 PM</p>
                    <p class="text-gray-500 mt-2">Daily</p>
                </div>
            </div>
        </section>

        {{-- ============================= --}}
        {{-- 7. STORE GALLERY (Horizontal & Interactive) --}}
        {{-- ============================= --}}
        <section class="py-16 md:py-24 relative overflow-hidden">
            
            {{-- Background Decoration --}}
            <div class="absolute top-1/2 left-0 w-full h-64 bg-purple-600/5 -skew-y-3 z-0 transform -translate-y-1/2"></div>

            <div class="custom-container relative z-10">
                
                {{-- Header --}}
                <div class="flex items-end justify-between mb-10 px-2" data-aos="fade-right">
                    <div>
                        <span class="text-yellow-500 font-bold tracking-wider uppercase text-sm">Peek Inside</span>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2">
                            Our <span class="text-purple-600">Store Gallery</span>
                        </h2>
                    </div>
                    
                    {{-- Scroll Indicator (Visible on Desktop) --}}
                    <div class="hidden md:flex gap-2">
                        <div class="w-12 h-1 bg-purple-200 rounded-full"></div>
                        <div class="w-4 h-1 bg-purple-600 rounded-full animate-pulse"></div>
                    </div>
                </div>

                {{-- 
                    GALLERY SCROLLER 
                    - Horizontal Scroll
                    - Snap effect
                    - Hidden Scrollbar
                --}}
                <div class="flex overflow-x-auto space-x-6 pb-12 hide-scrollbar snap-x snap-mandatory" data-aos="fade-up" data-aos-delay="200">
                    
                    {{-- PHOTO 1 --}}
                    <div class="tilt-card flex-shrink-0 w-80 md:w-96 snap-center group cursor-pointer">
                        <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg border border-white/50">
                            {{-- Image --}}
                            <img src="{{ asset('images/STORE.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110 group-hover:rotate-1" 
                                 alt="Store Interior">
                            
                            {{-- Overlay Gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/90 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition"></div>

                            {{-- Caption --}}
                            <div class="absolute bottom-0 left-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                                <span class="bg-yellow-400 text-purple-900 text-xs font-bold px-2 py-1 rounded mb-2 inline-block">Interior</span>
                                <h3 class="text-white text-xl font-bold">Cozy Shopping Aisles</h3>
                            </div>
                        </div>
                    </div>

                    {{-- PHOTO 2 --}}
                    <div class="tilt-card flex-shrink-0 w-80 md:w-96 snap-center group cursor-pointer">
                        <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg border border-white/50">
                            <img src="{{ asset('images/doggo.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110 group-hover:rotate-1" 
                                 alt="Grooming">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/90 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition"></div>
                            <div class="absolute bottom-0 left-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                                <span class="bg-pink-400 text-white text-xs font-bold px-2 py-1 rounded mb-2 inline-block">Hello</span>
                                <h3 class="text-white text-xl font-bold">Arf!</h3>
                            </div>
                        </div>
                    </div>

                    {{-- PHOTO 3 --}}
                    <div class="tilt-card flex-shrink-0 w-80 md:w-96 snap-center group cursor-pointer">
                        <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg border border-white/50">
                            <img src="{{ asset('images/say-treats-wall.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110 group-hover:rotate-1" 
                                 alt="Treats">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/90 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition"></div>
                            <div class="absolute bottom-0 left-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                                <span class="bg-green-400 text-green-900 text-xs font-bold px-2 py-1 rounded mb-2 inline-block">Pets</span>
                                <h3 class="text-white text-xl font-bold">Cuties</h3>
                            </div>
                        </div>
                    </div>

                    {{-- PHOTO 4 --}}
                    <div class="tilt-card flex-shrink-0 w-80 md:w-96 snap-center group cursor-pointer">
                        <div class="relative h-64 md:h-80 rounded-3xl overflow-hidden shadow-lg border border-white/50">
                            <img src="{{ asset('images/waaaa.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110 group-hover:rotate-1" 
                                 alt="Puppies">
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/90 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition"></div>
                            <div class="absolute bottom-0 left-0 p-6 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                                <span class="bg-blue-400 text-white text-xs font-bold px-2 py-1 rounded mb-2 inline-block">HELLO</span>
                                <h3 class="text-white text-xl font-bold">You are Welcome Here!!</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</x-app-layout>