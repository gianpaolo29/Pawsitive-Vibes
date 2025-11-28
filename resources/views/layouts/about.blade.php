<x-app-layout>
    {{-- Custom CSS for this page --}}
    <style>
        .about-header-bg {
            background: radial-gradient(circle at top right, #8a2be2 0%, transparent 40%),
                        radial-gradient(circle at bottom left, #F9DF97 0%, transparent 40%),
                        #f8f9fa;
        }
        .text-shadow { text-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>

    <div class="bg-gray-50 min-h-screen pb-20 overflow-x-hidden">

        {{-- ============================= --}}
        {{-- 1. HERO SECTION --}}
        {{-- ============================= --}}
        <div class="relative about-header-bg pt-32 pb-20 px-4 text-center overflow-hidden">
            {{-- Floating Icons --}}
            <i class="fas fa-paw text-6xl text-purple-200 absolute top-20 left-10 animate-float"></i>
            <i class="fas fa-heart text-6xl text-yellow-200 absolute bottom-10 right-10 animate-float" style="animation-delay: 2s"></i>

            <div class="relative z-10 max-w-4xl mx-auto" data-aos="zoom-in">
                <span class="text-purple-600 font-extrabold tracking-widest uppercase text-xs bg-white px-4 py-2 rounded-full mb-6 inline-block shadow-sm">
                    Our Journey
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    Driven by Love, <br> <span class="text-purple-600">Defined by Compassion.</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    From a simple love for animals to a meaningful mission. Learn about our journey and what drives us to provide the best for your pets.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10">
            
            {{-- ============================= --}}
            {{-- 2. OUR BEGINNING (Cooky & Loki) --}}
            {{-- ============================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-24">
                {{-- Text --}}
                <div data-aos="fade-right">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 mr-3 text-lg">
                            <i class="fas fa-heart"></i>
                        </span>
                        Our Beginning
                    </h2>
                    <div class="prose text-gray-600 leading-relaxed space-y-4">
                        <p>
                            Founded in <strong>April 2025</strong>, Pawsitive Vibes grew from a simple love for animals—especially our two dogs, 
                            <span class="text-purple-600 font-bold">Cooky and Loki</span>.
                        </p>
                        <p>
                            What began as a small idea sparked by the desire to give them the best care gradually expanded into a growing space where fellow pet lovers can find quality products, trusted guidance, and a community that shares the same passion.
                        </p>
                        <p class="italic border-l-4 border-yellow-400 pl-4 bg-yellow-50 p-2 rounded-r-lg">
                            "Cooky and Loki became the inspiration behind every product we choose and every service we provide."
                        </p>
                    </div>
                </div>

                {{-- Image (Cooky & Loki) --}}
                <div class="tilt-card relative" data-aos="fade-left">
                    <div class="absolute inset-0 bg-purple-600 rounded-3xl transform rotate-3 opacity-20"></div>
                    
                    {{-- 
                        IMPORTANT: 
                        Since we cannot link directly to Facebook images securely, 
                        you should download the image, save it as 'cooky-loki.jpg' in 'public/images/' 
                        and use: asset('images/cooky-loki.jpg')
                    --}}
                    <img src="{{ asset('images/cooky-loki.jpg') }}" 
                        class="relative w-full h-80 object-cover rounded-3xl shadow-xl transform transition duration-500 hover:scale-105" 
                        alt="Cooky and Loki">
                    
                    <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-4 py-2 rounded-xl shadow-lg">
                        <p class="text-sm font-bold text-gray-800">🐾 Cooky & Loki</p>
                    </div>
                </div>
            </div>

            {{-- ============================= --}}
            {{-- 3. MISSION & PRODUCTS --}}
            {{-- ============================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center mb-24 flex-col-reverse">
                
                {{-- Image --}}
                <div class="tilt-card relative order-2 md:order-1" data-aos="fade-right">
                    <div class="absolute inset-0 bg-yellow-400 rounded-3xl transform -rotate-3 opacity-20"></div>
                    <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&w=800&q=80" 
                         class="relative w-full h-80 object-cover rounded-3xl shadow-xl transform transition duration-500 hover:scale-105" 
                         alt="Our Products">
                </div>

                {{-- Text --}}
                <div class="order-1 md:order-2" data-aos="fade-left">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
                        <span class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 mr-3 text-lg">
                            <i class="fas fa-box-open"></i>
                        </span>
                        Our Mission
                    </h2>
                    <div class="prose text-gray-600 leading-relaxed space-y-4">
                        <p>
                            From wet and dry dog food to treats, vitamins, and toys, we carefully handpick each product to ensure safety and nutrition.
                        </p>
                        <p>
                            We want every pet to experience comfort, happiness, and good health—because they are more than just animals; they are family.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ============================= --}}
            {{-- NEW SECTION: SAY TREATS WALL --}}
            {{-- ============================= --}}
            <div class="mb-24 text-center">
                
                {{-- Section Header --}}
                <div data-aos="fade-down">
                    <span class="text-yellow-600 font-bold tracking-wider uppercase text-xs bg-yellow-100 px-4 py-2 rounded-full mb-4 inline-block">
                        Community Love
                    </span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8">
                        The <span class="text-purple-600">"Say Treats"</span> Wall
                    </h2>
                    <p class="text-gray-500 max-w-2xl mx-auto mb-10">
                        Our happy customers and their fur-babies! Every photo tells a story of joy, wagging tails, and pawsitive vibes.
                    </p>
                </div>

                {{-- The Photo Grid (Polaroid Style) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- PHOTO 1 --}}
                    <div class="tilt-card group relative bg-white p-4 pb-12 shadow-xl transform rotate-2 hover:rotate-0 transition duration-500 hover:z-10" data-aos="fade-up" data-aos-delay="0">
                        {{-- Tape Effect --}}
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-32 h-8 bg-yellow-100/80 rotate-1 shadow-sm z-20 backdrop-blur-sm"></div>
                        
                        <div class="overflow-hidden h-64 w-full bg-gray-100 shadow-inner">
                            <img src="{{ asset('images/say-treats-wall.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110" 
                                 alt="Happy Customer 1">
                        </div>
                        <p class="absolute bottom-4 left-0 right-0 text-center font-handwriting text-gray-600 font-bold text-lg font-mono">
                            #PawsitiveVibes
                        </p>
                    </div>

                    {{-- PHOTO 2 --}}
                    <div class="tilt-card group relative bg-white p-4 pb-12 shadow-xl transform -rotate-2 hover:rotate-0 transition duration-500 hover:z-10" data-aos="fade-up" data-aos-delay="150">
                        {{-- Tape Effect --}}
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-32 h-8 bg-purple-100/80 -rotate-1 shadow-sm z-20 backdrop-blur-sm"></div>

                        <div class="overflow-hidden h-64 w-full bg-gray-100 shadow-inner">
                            <img src="{{ asset('images/say-treats-wall2.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110" 
                                 alt="Happy Customer 2">
                        </div>
                        <p class="absolute bottom-4 left-0 right-0 text-center font-handwriting text-gray-600 font-bold text-lg font-mono">
                            Happy Tails 🐾
                        </p>
                    </div>

                    {{-- PHOTO 3 --}}
                    <div class="tilt-card group relative bg-white p-4 pb-12 shadow-xl transform rotate-1 hover:rotate-0 transition duration-500 hover:z-10" data-aos="fade-up" data-aos-delay="300">
                        {{-- Tape Effect --}}
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 w-32 h-8 bg-pink-100/80 rotate-2 shadow-sm z-20 backdrop-blur-sm"></div>

                        <div class="overflow-hidden h-64 w-full bg-gray-100 shadow-inner">
                            <img src="{{ asset('images/say-treats-wall3.jpg') }}" 
                                 class="w-full h-full object-cover transform transition duration-700 group-hover:scale-110" 
                                 alt="Happy Customer 3">
                        </div>
                        <p class="absolute bottom-4 left-0 right-0 text-center font-handwriting text-gray-600 font-bold text-lg font-mono">
                            Say Treats! 🦴
                        </p>
                    </div>

                </div>
            </div>

            {{-- ============================= --}}
            {{-- 4. WELFARE COMMITMENT (Glass Card) --}}
            {{-- ============================= --}}
            <div class="relative bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl p-8 md:p-12 text-white shadow-2xl mb-24 overflow-hidden" data-aos="fade-up">
                {{-- Background Pattern --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10 text-center max-w-3xl mx-auto">
                    <div class="inline-block bg-white/20 p-4 rounded-full mb-6 animate-float">
                        <i class="fas fa-hand-holding-heart text-4xl text-yellow-300"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold mb-6">Commitment to Animal Welfare</h2>
                    <p class="text-lg opacity-90 leading-relaxed mb-8">
                        A meaningful part of our mission is helping animals beyond our own walls. We openly accept donations of pet food and supplies for independent rescuers. Every donation brings comfort to a hungry stray and hope to animals in need.
                    </p>
                    <a href="{{ route('customer.donate') }}" class="inline-block bg-white text-purple-700 font-bold px-8 py-3 rounded-full shadow-lg hover:bg-yellow-300 hover:text-gray-900 transition transform hover:scale-105">
                        Support Our Cause
                    </a>
                </div>
            </div>

            {{-- ============================= --}}
            {{-- 5. LOCATION (Map Card) --}}
            {{-- ============================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20" data-aos="fade-up">
                
                {{-- Details --}}
                <div class="bg-white rounded-3xl p-8 shadow-lg border border-gray-100 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-map-marker-alt text-red-500 mr-3"></i> Visit Us
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <strong>Address:</strong><br>
                        122 JP Laurel St., Brgy. 2-Poblacion, Nasugbu, Batangas
                    </p>
                    <p class="text-gray-600 mb-6">
                        <strong>Landmark:</strong><br>
                        Short walk from Alfamart and DLTB Bus Terminal.
                    </p>
                    <a href="https://www.facebook.com/profile.php?id=61575048088417" target="_blank" class="flex items-center justify-center w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition">
                        <i class="fab fa-facebook-f mr-2"></i> Join us on Facebook
                    </a>
                </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>