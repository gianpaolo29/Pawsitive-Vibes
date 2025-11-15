@php
    use Illuminate\Support\Facades\Auth;

    function nav_active($pattern) {
        $isActive = request()->is($pattern);
        $activeClasses = 'bg-violet-50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold';
        $inactiveClasses = 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100';
        $iconActiveColor = 'text-violet-600 dark:text-violet-400';
        $iconInactiveColor = 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300';

        return [
            'link' => $isActive ? $activeClasses : $inactiveClasses,
            'icon' => $isActive ? $iconActiveColor : $iconInactiveColor,
            'is_active' => $isActive,
        ];
    }
    $user = Auth::user();

    $nav_items = [
        'Dashboard'  => ['route' => 'admin/dashboard',  'icon' => 'M2.25 12 8.954-8.955c.44-.44 1.152-.44 1.591 0L21.75 12M6 10v10h4v-5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v5h4V10'],
        'Products'   => ['route' => 'admin/products',   'icon' => 'M3 7.5h18M3 12h18M3 16.5h18'],
        'Customers'  => ['route' => 'admin/customers',  'icon' => 'M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM21 8.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0ZM8.624 21A12.3 12.3 0 0 1 3 19.234a6.375 6.375 0 0 1 11.964-3.07M15 19.234a9.5 9.5 0 0 0 7.5-.734 4.125 4.125 0 0 0-7.533-2.493'],
        'Analytics'  => ['route' => 'admin/analytics',  'icon' => 'M4.5 19.5h15M6 16.5V9m6 7.5V6m6 13.5V12'],
    ];

    $order_group = [
        'Orders' => [
            'route' => 'admin/orders', // Parent route pattern
            'icon' => 'M4.5 6.75h15l-1.5 10.5a2.25 2.25 0 0 1-2.25 1.95H8.25A2.25 2.25 0 0 1 6 17.25L4.5 6.75z',
            'children' => [
                'All Orders'     => ['route' => 'admin/orders',            'icon' => 'M4.5 6.75h15M4.5 12h15M4.5 17.25h15'],
                'Pending Orders' => ['route' => 'admin/orders/pending',    'icon' => 'M12 8v4l3 3'],
                'Completed' => ['route' => 'admin/orders/completed',    'icon' => 'M3 16.5c0 .28.22.5.5.5h1.5a.5.5 0 0 0 .5-.5V10c0-.28-.22-.5-.5-.5H3.5a.5.5 0 0 0-.5.5v6.5z'],
            ]
        ]
    ];

    // Loyalty remains separate
    $loyalty_items = [
        'Promotions' => ['route' => 'admin/promotions', 'icon' => 'M20 13 12 21l-8-8V4h9l7 9ZM7.5 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z'],
    ];

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pawsitive VIbes</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>
    @stack('scripts')
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        :root{
            --header-h: 64px;
            --sidebar-lg: 18rem;        
            --sidebar-mini: 5rem;     
            --sidebar-pad: var(--sidebar-lg); 
        }

        .layout-main{ padding-top: var(--header-h); }

        @media (min-width:1024px){
            .layout-main{ padding-left: var(--sidebar-pad); }
            .header-shell{ padding-left: var(--sidebar-pad); }
        }

        .thin-scrollbar::-webkit-scrollbar{width:8px;height:8px}
        .thin-scrollbar::-webkit-scrollbar-thumb{background:rgba(0,0,0,.15);border-radius:8px}
        .thin-scrollbar:hover::-webkit-scrollbar-thumb{background:rgba(0,0,0,.28)}

        .sidebar-transition { transition: width .35s cubic-bezier(0.4, 0, 0.2, 1); }
        .header-shell, .layout-main { transition: padding-left .35s cubic-bezier(0.4, 0, 0.2, 1); }
        @media (prefers-reduced-motion: reduce){
            .sidebar-transition, .header-shell, .layout-main { transition: none; }
        }

        [x-cloak]{ display:none !important; }
    </style>
    @stack('scripts')

</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    
<div
    x-data="{
        mobileOpen:false,
        sidebarCollapsed:false,
        init(){
            if (window.innerWidth < 1280) this.sidebarCollapsed = true;

            const saved = localStorage.getItem('pawsitive.sidebarCollapsed');
            if (saved !== null) this.sidebarCollapsed = saved === '1';

            const syncSidebarState = (v) => {
                document.documentElement.style.setProperty(
                    '--sidebar-pad',
                    getComputedStyle(document.documentElement).getPropertyValue(v ? '--sidebar-mini' : '--sidebar-lg')
                );
                localStorage.setItem('pawsitive.sidebarCollapsed', v ? '1' : '0');
            };

            this.$watch('sidebarCollapsed', syncSidebarState);

            syncSidebarState(this.sidebarCollapsed);
        }
    }"
    class="min-h-screen"
>

    <aside
        class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:flex-col border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 thin-scrollbar overflow-y-auto sidebar-transition shadow-xl dark:shadow-none"
        :class="sidebarCollapsed ? 'lg:w-[var(--sidebar-mini)]' : 'lg:w-[var(--sidebar-lg)]'"
    >
        <div class="px-3 pt-3 pb-2">
            <div class="flex items-center gap-2 h-12 px-2">
                <img src="{{ asset('images/pawsitive-logo.jpg') }}" class="h-9 w-9 rounded-xl shadow-md ring-1 ring-violet-200" alt="Pawsitive Logo">
                <span class="font-[Pacifico] text-xl text-violet-600 dark:text-violet-400 truncate"
                    x-show="!sidebarCollapsed"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-3"
                    x-transition:enter-end="opacity-100 translate-x-0">Pawsitive Vibes</span>
            </div>
        </div>

        <nav class="mt-4 space-y-1 px-3 flex-grow">
    
    {{-- STANDARD NAV ITEMS --}}
    @foreach($nav_items as $name => $item)
        @php $nav = nav_active($item['route'].'*'); @endphp
        <a href="{{ url($item['route']) }}"
           :title="sidebarCollapsed ? '{{ $name }}' : null"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all duration-200 {{ $nav['link'] }}">
            <svg class="h-5 w-5 shrink-0 transition-colors {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="truncate">{{ $name }}</span>
            <span x-show="sidebarCollapsed" class="sr-only">{{ $name }}</span>
        </a>
    @endforeach

    {{-- ORDERS EXPANDABLE GROUP (USING ALPINE.JS FOR COLLAPSE) --}}
    @foreach($order_group as $groupName => $group)
        @php
            $nav = nav_active($group['route']);
            $isGroupActive = $nav['is_active'];
            // Check if any child route is active to determine if the parent should be active/open
            foreach ($group['children'] as $childItem) {
                if (nav_active($childItem['route'].'*')['is_active']) { // Added '*' to child routes for flexibility
                    $isGroupActive = true;
                    break;
                }
            }
            $parentLinkClasses = $isGroupActive
                ? 'bg-violet-50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold'
                : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100';
            $parentIconClasses = $isGroupActive
                ? 'text-violet-600 dark:text-violet-400'
                : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300';
        @endphp

        <div x-data="{ ordersOpen: {{ $isGroupActive ? 'true' : 'false' }} }" :class="sidebarCollapsed ? 'relative' : ''">
            {{-- Parent Toggle Button --}}
            <button
                @click="ordersOpen = !ordersOpen"
                :title="sidebarCollapsed ? '{{ $groupName }}' : null"
                class="group flex w-full items-center rounded-xl px-3 py-2.5 text-sm transition-all duration-300 {{ $parentLinkClasses }}"
                :class="sidebarCollapsed ? 'justify-center' : 'justify-between'"
                :aria-expanded="ordersOpen.toString()"
            >
                <div class="flex items-center gap-3">
                    {{-- Parent Icon --}}
                    <svg class="h-5 w-5 shrink-0 transition-colors {{ $parentIconClasses }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="{{ $group['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                    {{-- Parent Name --}}
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="truncate">{{ $groupName }}</span>
                </div>

                {{-- Chevron Icon --}}
                <svg x-show="!sidebarCollapsed" class="h-5 w-5 shrink-0 transition-transform" :class="ordersOpen ? 'rotate-90' : 'rotate-0'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                {{-- Screen reader text for collapsed state --}}
                <span x-show="sidebarCollapsed" class="sr-only">{{ $groupName }}</span>
            </button>

            {{-- Collapsible Child Menu (smooth transition with x-collapse) --}}
            <div x-cloak
                x-show="ordersOpen"
                x-collapse.duration.300ms
                class="mt-1 space-y-1 overflow-hidden"
                :class="sidebarCollapsed ? 'absolute left-[var(--sidebar-mini)] top-0 w-64 p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-20' : ''"
                @click.outside="sidebarCollapsed ? ordersOpen = false : null"
            >
                <div :class="sidebarCollapsed ? 'space-y-1' : 'ml-4 space-y-1 border-l border-gray-200 dark:border-gray-700 pl-3'">
                    @foreach($group['children'] as $childName => $childItem)
                        @php $childNav = nav_active($childItem['route']); @endphp
                        <a href="{{ url($childItem['route']) }}"
                           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all duration-300 {{ $childNav['link'] }}"
                           :class="sidebarCollapsed ? 'bg-white dark:bg-gray-800' : ''"
                           :title="sidebarCollapsed ? '{{ $childName }}' : null"
                        >
                            <svg class="h-5 w-5 shrink-0 transition-colors" :class="{{ $childNav['is_active'] ? $parentIconClasses : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="{{ $childItem['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="truncate">{{ $childName }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    {{-- REMAINING SIMPLE NAV ITEMS (Loyalty) --}}
    @foreach($loyalty_items as $name => $item)
        @php $nav = nav_active($item['route'].'*'); @endphp
        <a href="{{ url($item['route']) }}"
           :title="sidebarCollapsed ? '{{ $name }}' : null"
           class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all duration-300 {{ $nav['link'] }}">
            <svg class="h-5 w-5 shrink-0 transition-colors {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="truncate">{{ $name }}</span>
            <span x-show="sidebarCollapsed" class="sr-only">{{ $name }}</span>
        </a>
    @endforeach

</nav>

    </aside>

    <header
        class="fixed inset-x-0 top-0 z-30 h-[var(--header-h)] bg-white/95 dark:bg-gray-900/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 shadow-sm header-shell transition-all duration-300 ease-out"
    >
      <div class="h-full flex items-center gap-4 px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-3 shrink-0">
          <button @click="mobileOpen = true" class="-m-2.5 p-2.5 text-gray-700 dark:text-gray-300 lg:hidden" aria-label="Open sidebar menu">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" />
            </svg>
          </button>

          <button
            @click="sidebarCollapsed = !sidebarCollapsed"
            class="hidden lg:inline-flex items-center justify-center h-9 w-9 rounded-full border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
            :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
            :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
            :aria-expanded="(!sidebarCollapsed).toString()"
          >
              <svg
                x-show="!sidebarCollapsed"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
                        <svg
                x-show="sidebarCollapsed"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
  </svg>
          </button>
        </div>

        <div class="flex-1 min-w-0">
          <div class="relative w-full max-w-2xl lg:mx-0">
            <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.45 4.39l3.33 3.33a.75.75 0 1 1-1.06 1.06l-3.33-3.33A7 7 0 0 1 2 9Z"/>
            </svg>
            <input
              type="search"
              class="block w-full rounded-full border border-gray-300 dark:border-gray-600 pl-10 pr-4 py-2 text-sm focus:border-violet-500 focus:ring-1 focus:ring-violet-500 dark:bg-gray-800 dark:text-gray-100 placeholder-gray-400 shadow-sm"
              placeholder="Search products, orders, customers..."
              aria-label="Search the dashboard content"
            />
          </div>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <button class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors" aria-label="Notifications">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
              <path d="M14.857 17.082a23.85 23.85 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>

          <div x-data="{ userOpen: false }" class="relative">
            <button @click="userOpen = !userOpen" class="flex items-center gap-2" :aria-expanded="userOpen.toString()" aria-controls="user-menu" aria-label="User profile menu">
              <div class="text-right hidden sm:block">
                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user->name ?? 'Admin' }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Store Manager</div>
              </div>
              <img class="h-10 w-10 rounded-full ring-2 ring-violet-500/50 object-cover" src="{{ asset('images/pawsitive-logo.jpg') }}" alt="User Avatar">
            </button>

            <div
              x-cloak
              x-show="userOpen"
              @click.outside="userOpen = false"
              x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95"
              x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              id="user-menu"
              class="absolute right-0 z-50 mt-3 w-48 origin-top-right rounded-xl bg-white dark:bg-gray-700 shadow-xl ring-1 ring-black/5 focus:outline-none overflow-hidden"
              role="menu" aria-orientation="vertical" tabindex="-1"
            >
              <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-600">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $user->email ?? 'admin@example.com' }}</p>
                <p class="text-xs text-violet-600 dark:text-violet-400 mt-0.5">Manager</p>
              </div>
              <a href="{{ url('admin/profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" role="menuitem">Your Profile</a>
              <a href="{{ url('admin/settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" role="menuitem">Settings</a>
              <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 dark:border-gray-600">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/40 transition-colors" role="menuitem">Sign out</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div x-cloak x-show="mobileOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click.self="mobileOpen=false"></div>

    <aside x-cloak x-show="mobileOpen"
           x-transition:enter="transition transform duration-300 ease-out"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform duration-200 ease-in"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-xl p-4 lg:hidden thin-scrollbar overflow-y-auto">
        <div class="flex h-14 items-center gap-3 px-2 mb-4 border-b border-gray-200 dark:border-gray-700 pb-4">
            <img src="{{ asset('images/pawsitive-logo.jpg') }}" class="h-10 w-10 rounded-xl shadow-md ring-1 ring-violet-200" alt="Pawsitive Logo">
            <span class="font-[Pacifico] text-2xl text-violet-600 dark:text-violet-400">Pawsitive Vibes</span>
            <button @click="mobileOpen = false" class="ml-auto text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100" aria-label="Close sidebar menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <nav class="space-y-1">
    
    {{-- STANDARD NAV ITEMS --}}
    @foreach($nav_items as $name => $item)
        @php $nav = nav_active($item['route'].'*'); @endphp
        <a href="{{ url($item['route']) }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm {{ $nav['link'] }}"
            @click="mobileOpen=false">
            <svg class="h-5 w-5 shrink-0 transition-colors {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ $name }}
        </a>
    @endforeach

    {{-- ORDERS EXPANDABLE GROUP (MOBILE) --}}
    @foreach($order_group as $groupName => $group)
        @php
            $nav = nav_active($group['route']);
            $isGroupActive = $nav['is_active'];
            foreach ($group['children'] as $childItem) {
                if (nav_active($childItem['route'].'*')['is_active']) {
                    $isGroupActive = true;
                    break;
                }
            }
            $parentLinkClasses = $isGroupActive
                ? 'bg-violet-50 dark:bg-violet-900/50 text-violet-700 dark:text-violet-300 font-semibold'
                : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100';
            $parentIconClasses = $isGroupActive
                ? 'text-violet-600 dark:text-violet-400'
                : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300';
        @endphp
        
        <div x-data="{ mobileOrdersOpen: {{ $isGroupActive ? 'true' : 'false' }} }">
            {{-- Parent Toggle Button --}}
            <button
                @click="mobileOrdersOpen = !mobileOrdersOpen"
                class="group flex w-full items-center rounded-xl px-3 py-2.5 text-sm transition-all duration-200 {{ $parentLinkClasses }} justify-between"
                :aria-expanded="mobileOrdersOpen.toString()"
            >
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 shrink-0 transition-colors {{ $parentIconClasses }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="{{ $group['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ $groupName }}</span>
                </div>
                {{-- Chevron Icon --}}
                <svg class="h-5 w-5 shrink-0 transition-transform" :class="mobileOrdersOpen ? 'rotate-90' : 'rotate-0'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            {{-- Collapsible Child Menu (smooth transition with x-collapse) --}}
            <div x-cloak
                x-show="mobileOrdersOpen"
                x-collapse.duration.300ms
                class="mt-1 space-y-1 overflow-hidden ml-4 border-l border-gray-200 dark:border-gray-700 pl-3"
            >
                @foreach($group['children'] as $childName => $childItem)
                    @php $childNav = nav_active($childItem['route']); @endphp
                    <a href="{{ url($childItem['route']) }}"
                       class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all duration-200 {{ $childNav['link'] }}"
                       @click="mobileOpen=false"> {{-- Close mobile menu upon child click --}}
                        <svg class="h-5 w-5 shrink-0 transition-colors" :class="{{ $childNav['is_active'] ? $parentIconClasses : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="{{ $childItem['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $childName }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- REMAINING SIMPLE NAV ITEMS (Loyalty) --}}
    @foreach($loyalty_items as $name => $item)
        @php $nav = nav_active($item['route'].'*'); @endphp
        <a href="{{ url($item['route']) }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm {{ $nav['link'] }}"
            @click="mobileOpen=false">
            <svg class="h-5 w-5 shrink-0 transition-colors {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ $name }}
        </a>
    @endforeach
</nav>
    </aside>

        <div x-data="toast()" x-init="init()" class="fixed top-4 right-4 z-[9999]">
      <template x-if="show">
        <div
          x-transition.opacity.duration.200ms
          class="rounded-lg shadow-lg px-4 py-3 text-sm flex items-start gap-3"
          :class="type === 'success'
                  ? 'bg-emerald-50 text-emerald-800 ring-1 ring-emerald-200'
                  : 'bg-rose-50 text-rose-800 ring-1 ring-rose-200'">
          <svg x-show="type==='success'" class="h-5 w-5 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
          <svg x-show="type==='error'" class="h-5 w-5 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
          <div x-text="message"></div>
          <button class="ml-2 text-xs underline" @click="hide()">Close</button>
        </div>
      </template>
    </div>

    <script>
      function toast() {
        return {
          show: false,
          message: '',
          type: 'success',
          timer: null,
          fire(msg, type = 'success', ms = 3000) {
            this.message = msg;
            this.type = type;
            this.show = true;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.show = false, ms);
          },
          hide() { this.show = false; },
          init() {
            // Listen to manual dispatches anywhere
            window.addEventListener('toast', e => this.fire(e.detail.message, e.detail.type ?? 'success'));

            // Auto-fire from Laravel flash
            @if (session('success'))
              this.fire(@js(session('success')), 'success');
            @endif

            @if (session('error'))
              this.fire(@js(session('error')), 'error');
            @endif

            // (Optional) show validation error count
            @if ($errors->any())
              this.fire('There were {{ $errors->count() }} validation error(s).', 'error', 5000);
            @endif
          }
        }
      }
    </script>
    

    <main class="layout-main transition-all duration-300 ease-out min-h-[calc(100vh_-_var(--header-h))]">
        <div class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </div>
    </main>

</div>
</body>
</html>