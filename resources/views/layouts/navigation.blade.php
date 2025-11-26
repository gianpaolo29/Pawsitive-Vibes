<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 h-20 sm:h-24 sticky top-0 z-10 shadow-sm">

    <div class="px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex justify-between items-center h-full">

            {{-- LOGO --}}
            <div class="shrink-0 flex items-center">
                <a href="/customer/dashboard"
                   class="text-3xl font-extrabold text-[#8a2be2] tracking-tight flex items-center">

                    {{-- FIX: USE src="" not href="" --}}
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Pawsitive Vibes Logo"
                         class="h-10 w-10 mr-2 rounded-full object-cover" />

                    Pawsitive Vibes
                    <span class="ml-2 w-1.5 h-1.5 bg-[#F9DF71] rounded-full animate-pulse"></span>
                </a>
            </div>

            {{-- DESKTOP NAV --}}
            <div class="hidden sm:flex sm:items-center sm:gap-3">

                @php
                    $current = request()->path();

                    $isActive = fn($path) => trim($current, '/') === trim($path, '/');

                    $linkClass = function ($active) {
                        return
                            "flex flex-col items-center justify-center w-20 h-16 relative transition 
                            " . ($active
                                ? "text-[#8a2be2] bg-[#8a2be2]/10 rounded-xl border-b-2 border-[#8a2be2]"
                                : "text-gray-500 hover:text-[#8a2be2] hover:bg-[#8a2be2]/5 rounded-xl");
                    };

                    $iconClass = "h-6 w-6";
                @endphp

                {{-- HOME --}}
                <a href="/customer/dashboard" class="{{ $linkClass($isActive('customer/dashboard')) }}">
                    <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                    @if ($isActive('customer/dashboard'))
                        <span class="absolute bottom-1 w-2 h-2 bg-[#F9DF71] rounded-full z-20"></span>
                    @endif
                </a>

                {{-- FAVORITES --}}
                <a href="/favorites" class="{{ $linkClass($isActive('favorites')) }}">
                    <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <span class="text-xs mt-1">Favorites</span>
                    @if ($isActive('favorites'))
                        <span class="absolute bottom-1 w-2 h-2 bg-[#F9DF71] rounded-full z-20"></span>
                    @endif
                </a>

                {{-- DONATE --}}
                <a href="/donate" class="{{ $linkClass($isActive('donate')) }}">
                    <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
                        <path d="M2 12c0 3.1 1.9 6.2 4 7.2"/>
                        <path d="M22 12c0 3.1-1.9 6.2-4 7.2"/>
                    </svg>
                    <span class="text-xs mt-1">Donate</span>
                    @if ($isActive('donate'))
                        <span class="absolute bottom-1 w-2 h-2 bg-[#F9DF71] rounded-full z-20"></span>
                    @endif
                </a>

                {{-- CART --}}
                <a href="/cart" class="{{ $linkClass($isActive('cart')) }}">
                    <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 12.81a2 2 0 0 0 2 1.19h9.24a2 2 0 0 0 2-1.19L23 5H6"/>
                    </svg>
                    <span class="text-xs mt-1">Cart</span>
                    @if ($isActive('cart'))
                        <span class="absolute bottom-1 w-2 h-2 bg-[#F9DF71] rounded-full z-20"></span>
                    @endif
                </a>

                {{-- PROFILE --}}
                <a href="/profile" class="{{ $linkClass($isActive('profile')) }}">
                    <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span class="text-xs mt-1">Profile</span>
                    @if ($isActive('profile'))
                        <span class="absolute bottom-1 w-2 h-2 bg-[#F9DF71] rounded-full z-20"></span>
                    @endif
                </a>
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white shadow-md">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link href="/customer/dashboard" :active="$isActive('customer/dashboard')">
                Home
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/favorites" :active="$isActive('favorites')">
                Favorites
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/donate" :active="$isActive('donate')">
                Donate
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/cart" :active="$isActive('cart')">
                Cart
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium">{{ Auth::user()->name ?? 'Guest' }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email ?? '' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="/profile" :active="$isActive('profile')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="/logout">
                    @csrf
                    <x-responsive-nav-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
