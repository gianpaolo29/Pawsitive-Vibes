<nav x-data="{ open: false }" class="bg-white border-b h-20 sm:h-24 sticky top-0 z-10 shadow-sm">

    @php
        $current = request()->path();

        $isActive = fn($path) => trim($current, '/') === trim($path, '/');

        $linkClass = fn($active) =>
            "flex flex-col items-center justify-center w-20 h-16 relative transition rounded-xl " .
            ($active
                ? "text-[#8a2be2] bg-[#8a2be2]/10 border-b-2 border-[#8a2be2] shadow-md"
                : "text-gray-500 hover:text-[#8a2be2] hover:bg-[#8a2be2]/5");

        $iconClass = "h-6 w-6";

        function navLink($url, $label, $iconSvg, $active, $class) {
            if (!Auth::check()) {
                // Guest: auto redirect to login
                return '
                    <a href="/login" class="'.$class.'">
                        '.$iconSvg.'
                        <span class="text-xs mt-1">'.$label.'</span>
                    </a>
                ';
            }

            // Logged in: go to real URL
            return '
                <a href="'.$url.'" class="'.$class.'">
                    '.$iconSvg.'
                    <span class="text-xs mt-1">'.$label.'</span>
                </a>
            ';
        }
    @endphp

    <div class="px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">

            {{-- LOGO --}}
            <a href="/" class="shrink-0 flex items-center text-3xl font-extrabold text-[#8a2be2]">
                <img src="{{ asset('images/logo.png') }}" class="h-10 w-10 mr-2 rounded-full object-cover">
                Pawsitive Vibes
                <span class="ml-2 w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></span>
            </a>

            {{-- DESKTOP NAV --}}
            <div class="hidden sm:flex sm:items-center sm:gap-3">

                {{-- HOME (no auto login) --}}
                <a href="/" class="{{ $linkClass($isActive('/')) }}">
                    <svg class="{{ $iconClass }}" fill="currentColor" stroke="currentColor">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>

                {{-- SHOP --}}
                {!! navLink(
                    '/customer/shop',
                    'Shop',
                    '<svg class="'.$iconClass.'" fill="currentColor"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/></svg>',
                    $isActive('shop'),
                    $linkClass($isActive('/customer/shop'))
                ) !!}

                {{-- FAVORITES --}}
                {!! navLink(
                    '/customer/favorites',
                    'Favorites',
                    '<svg class="'.$iconClass.'" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l7.78-7.78z"/></svg>',
                    $isActive('favorites'),
                    $linkClass($isActive('/customer/favorites'))
                ) !!}

                {{-- DONATE --}}
                {!! navLink(
                    '/customer/donate',
                    'Donate',
                    '<svg class="'.$iconClass.'" fill="none" stroke="currentColor"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/></svg>',
                    $isActive('donate'),
                    $linkClass($isActive('/customer/donate'))
                ) !!}

                {{-- CART --}}
                {!! navLink(
                    '/customer/cart',
                    'Cart',
                    '<svg class="'.$iconClass.'" fill="currentColor"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 12.8a2 2 0 0 0 2 1.2h9.3a2 2 0 0 0 2-1.2L23 5H6"/></svg>',
                    $isActive('cart'),
                    $linkClass($isActive('/customer/cart'))
                ) !!}

                {{-- PROFILE --}}
                {!! navLink(
                    '/customer/profile',
                    'Profile',
                    '<svg class="'.$iconClass.'" fill="currentColor"><circle cx="12" cy="7" r="4"/><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/></svg>',
                    $isActive('/customer/profile'),
                    $linkClass($isActive('/customer/profile'))
                ) !!}

                {{-- LOGOUT (only for logged in) --}}
                @auth
                <form method="POST" action="/logout" id="logoutFormDesktop">
                    @csrf
                    <button type="button" class="{{ $linkClass(false) }}"
                        @click="Swal.fire({
                            title:'Logout?',
                            icon:'warning',
                            showCancelButton:true,
                            confirmButtonColor:'#8a2be2'
                        }).then(r => { if(r.isConfirmed) document.getElementById('logoutFormDesktop').submit(); })">
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor">
                            <polyline points="16 17 21 12 16 7"/>
                        </svg>
                        <span class="text-xs mt-1">Logout</span>
                    </button>
                </form>
                @endauth

            </div>

            {{-- MOBILE MENU TOGGLE --}}
            <button @click="open = !open" class="sm:hidden p-2 text-gray-500">
                <svg class="h-7 w-7" fill="none" stroke="currentColor">
                    <path x-show="!open" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-show="open" class="sm:hidden bg-white shadow-md">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link href="/">Home</x-responsive-nav-link>

            {{-- MOBILE SHOP --}}
            <x-responsive-nav-link href="{{ Auth::check() ? '/customer/shop' : '/login' }}">Shop</x-responsive-nav-link>

            {{-- MOBILE FAVORITES --}}
            <x-responsive-nav-link href="{{ Auth::check() ? '/customer/favorites' : '/login' }}">Favorites</x-responsive-nav-link>

            {{-- MOBILE DONATE --}}
            <x-responsive-nav-link href="{{ Auth::check() ? '/customer/donate' : '/login' }}">Donate</x-responsive-nav-link>

            {{-- MOBILE CART --}}
            <x-responsive-nav-link href="{{ Auth::check() ? '/customer/cart' : '/login' }}">Cart</x-responsive-nav-link>

        </div>

        <div class="border-t pt-4 pb-3 px-4">
            <div class="font-medium">{{ Auth::user()->fname ?? 'Guest' }}</div>
            <div class="text-sm text-gray-500">{{ Auth::user()->email ?? '' }}</div>

            @auth
            <form method="POST" action="/logout" class="mt-3">
                @csrf
                <x-responsive-nav-link href="#"
                    onclick="event.preventDefault();
                        Swal.fire({
                            title:'Logout?',
                            icon:'warning',
                            showCancelButton:true,
                            confirmButtonColor:'#8a2be2'
                        }).then(r => { if(r.isConfirmed) this.closest('form').submit(); });">
                    Logout
                </x-responsive-nav-link>
            </form>
            @endauth
        </div>

    </div>

</nav>
