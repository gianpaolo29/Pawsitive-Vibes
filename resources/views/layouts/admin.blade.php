@php
    use Illuminate\Support\Facades\Auth;

    function nav_active($pattern) {
        $isActive = request()->is($pattern);
        $activeClasses = 'bg-gradient-to-r from-violet-500/10 to-purple-500/10 text-violet-700 dark:text-violet-300 font-semibold border-r-2 border-violet-500';
        $inactiveClasses = 'text-gray-600 dark:text-gray-300 hover:bg-gray-100/80 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-200';
        $iconActiveColor = 'text-violet-600 dark:text-violet-400';
        $iconInactiveColor = 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300';

        return [
            'link' => $isActive ? $activeClasses : $inactiveClasses,
            'icon' => $isActive ? $iconActiveColor : $iconInactiveColor,
            'is_active' => $isActive,
        ];
    }
    $user = Auth::user();
    $unreadNotificationsCount = $user
        ? $user->unreadNotifications()->count()
        : 0;

    $unreadChatCount = \App\Models\ChatMessage::where('sender_type', 'customer')
        ->where('is_read', false)->count();

    $openTicketsCount = \App\Models\SupportTicket::whereIn('status', ['open', 'in_progress'])->count();

    // Get latest 7 notifications (read + unread)
    $recentNotifications = $user
        ? $user->notifications()->latest()->take(7)->get()
        : collect();

    $nav_items = [
        'Dashboard'  => ['route' => 'admin/dashboard',  'icon' => 'M2.25 12 8.954-8.955c.44-.44 1.152-.44 1.591 0L21.75 12M6 10v10h4v-5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v5h4V10'],
        'Products'   => ['route' => 'admin/products',   'icon' => 'M3 7.5h18M3 12h18M3 16.5h18'],
        'Category'   => ['route' => 'admin/categories',   'icon' => 'M3 7.5h18M3 12h18M3 16.5h18'],
        'Customers'  => ['route' => 'admin/customers',  'icon' => 'M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM21 8.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0ZM8.624 21A12.3 12.3 0 0 1 3 19.234a6.375 6.375 0 0 1 11.964-3.07M15 19.234a9.5 9.5 0 0 0 7.5-.734 4.125 4.125 0 0 0-7.533-2.493'],
        'Analytics'  => ['route' => 'admin/analytics',  'icon' => 'M4.5 19.5h15M6 16.5V9m6 7.5V6m6 13.5V12'],
        'Donations'  => ['route' => 'admin/donations',  'icon' => 'M4.5 19.5h15M6 16.5V9m6 7.5V6m6 13.5V12'],
        'Tickets'    => ['route' => 'admin/tickets',    'icon' => 'M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z'],
        'Chat'       => ['route' => 'admin/chat',       'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
    ];

    $order_group = [
        'Orders' => [
            'route' => 'admin/orders',
            'icon' => 'M4.5 6.75h15l-1.5 10.5a2.25 2.25 0 0 1-2.25 1.95H8.25A2.25 2.25 0 0 1 6 17.25L4.5 6.75z',
            'children' => [
                'All Orders'     => ['route' => 'admin/orders',            'icon' => 'M4.5 6.75h15M4.5 12h15M4.5 17.25h15'],
                'Pending Orders' => ['route' => 'admin/orders/pending',    'icon' => 'M12 8v4l3 3'],
                'Completed' => ['route' => 'admin/orders/completed',    'icon' => 'M3 16.5c0 .28.22.5.5.5h1.5a.5.5 0 0 0 .5-.5V10c0-.28-.22-.5-.5-.5H3.5a.5.5 0 0 0-.5.5v6.5z'],
            ]
        ]
    ];

    $loyalty_items = [

    ];

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .thin-scrollbar::-webkit-scrollbar{width:6px;height:6px}
        .thin-scrollbar::-webkit-scrollbar-thumb{background:rgba(139, 92, 246, 0.3);border-radius:8px}
        .thin-scrollbar:hover::-webkit-scrollbar-thumb{background:rgba(139, 92, 246, 0.5)}
        .thin-scrollbar::-webkit-scrollbar-track{background:transparent}

        .sidebar-transition { transition: width .35s cubic-bezier(0.4, 0, 0.2, 1); }
        .header-shell, .layout-main { transition: padding-left .35s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Modern sidebar gradient */
        .sidebar-gradient {
            background: linear-gradient(135deg,
                rgb(255 255 255 / 98%) 0%,
                rgb(250 245 255 / 98%) 50%,
                rgb(245 243 255 / 98%) 100%);
        }

        .dark .sidebar-gradient {
            background: linear-gradient(135deg,
                rgb(17 24 39 / 98%) 0%,
                rgb(30 27 75 / 98%) 50%,
                rgb(35 28 76 / 98%) 100%);
        }

        /* Smooth backdrop blur */
        .backdrop-smooth {
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
        }

        /* Premium tooltip */
        .premium-tooltip {
            position: absolute;
            left: calc(100% + 14px);
            top: 50%;
            transform: translateY(-50%) scale(0.92);
            padding: 8px 14px;
            background: linear-gradient(135deg, rgba(109, 40, 217, 0.92), rgba(139, 92, 246, 0.92));
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.02em;
            white-space: nowrap;
            border-radius: 10px;
            pointer-events: none;
            opacity: 0;
            z-index: 999;
            box-shadow: 0 8px 24px rgba(109, 40, 217, 0.35), 0 2px 8px rgba(0,0,0,0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: opacity 0.2s cubic-bezier(0.4, 0, 0.2, 1), transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-tooltip::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            width: 10px;
            height: 10px;
            background: linear-gradient(135deg, rgba(109, 40, 217, 0.92), rgba(126, 58, 242, 0.92));
            border-left: 1px solid rgba(255, 255, 255, 0.18);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 2px;
        }
        .group:hover > .premium-tooltip {
            opacity: 1;
            transform: translateY(-50%) scale(1);
        }

        [x-cloak]{ display:none !important; }

        /* Smooth animations */
        .smooth-animate {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glass morphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .dark .glass-effect {
            background: rgba(17, 24, 39, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-violet-50/30">

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
        },
        // SweetAlert logout function
        confirmLogout() {
            Swal.fire({
                title: 'Ready to leave?',
                text: 'Are you sure you want to log out?',
                icon: 'question',
                iconColor: '#8b5cf6',
                showCancelButton: true,
                confirmButtonColor: '#8b5cf6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, log out!',
                cancelButtonText: 'Cancel',
                background: '#ffffff',
                color: '#1f2937',
                backdrop: 'rgba(139, 92, 246, 0.1)',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl',
                    confirmButton: 'rounded-lg px-6 py-2 font-semibold',
                    cancelButton: 'rounded-lg px-6 py-2 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the logout form
                    document.getElementById('logout-form').submit();
                }
            });
        }
    }"
    class="min-h-screen"
>

    <!-- Modern Sidebar -->
    <aside
        class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:flex-col border-r border-violet-200/50 sidebar-gradient backdrop-smooth thin-scrollbar overflow-y-auto sidebar-transition shadow-xl dark:shadow-2xl"
        :class="sidebarCollapsed ? 'lg:w-[var(--sidebar-mini)]' : 'lg:w-[var(--sidebar-lg)]'"
    >
        <div class="px-3 pt-4 pb-2">
            <div class="flex items-center h-12 smooth-animate" :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-2 px-2'">
                <div class="relative shrink-0">
                    <img src="{{ asset('images/pawsitive-logo.jpg') }}" class="h-10 w-10 rounded-xl shadow-lg ring-2 ring-violet-300/50 smooth-animate" alt="Pawsitive Logo">
                    <div class="absolute -inset-1 bg-violet-400/20 rounded-xl blur-sm -z-10"></div>
                </div>
                <span class="font-[Pacifico] text-xl bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent truncate smooth-animate"
                    x-show="!sidebarCollapsed"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-3"
                    x-transition:enter-end="opacity-100 translate-x-0">{{ config('app.name') }}</span>
            </div>
        </div>

        <nav class="mt-6 space-y-1 px-3 flex-grow">
            {{-- STANDARD NAV ITEMS --}}
            @foreach($nav_items as $name => $item)
                @php $nav = nav_active($item['route'].'*'); @endphp
                <a href="{{ url($item['route']) }}"
                   class="group relative flex items-center rounded-xl py-3 text-sm smooth-animate {{ $nav['link'] }}"
                   :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
                    <svg class="h-5 w-5 shrink-0 transition-all duration-200 {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="truncate font-medium">{{ $name }}</span>

                    @if($name === 'Tickets' && $openTicketsCount > 0)
                        <span x-show="!sidebarCollapsed" class="ml-auto inline-flex items-center justify-center w-5 h-5 bg-orange-500 text-white text-[10px] font-bold rounded-full animate-pulse">
                            {{ $openTicketsCount > 9 ? '9+' : $openTicketsCount }}
                        </span>
                        <span x-show="sidebarCollapsed" class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 bg-orange-500 text-white text-[8px] font-bold rounded-full animate-pulse">
                            {{ $openTicketsCount > 9 ? '9+' : $openTicketsCount }}
                        </span>
                    @endif

                    @if($name === 'Chat' && $unreadChatCount > 0)
                        <span x-show="!sidebarCollapsed" class="ml-auto inline-flex items-center justify-center w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full animate-pulse">
                            {{ $unreadChatCount > 9 ? '9+' : $unreadChatCount }}
                        </span>
                        <span x-show="sidebarCollapsed" class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 bg-red-500 text-white text-[8px] font-bold rounded-full animate-pulse">
                            {{ $unreadChatCount > 9 ? '9+' : $unreadChatCount }}
                        </span>
                    @endif

                    {{-- Premium Tooltip for collapsed state --}}
                    <div x-show="sidebarCollapsed" class="premium-tooltip">{{ $name }}</div>
                </a>
            @endforeach

            {{-- ORDERS EXPANDABLE GROUP --}}
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
                        ? 'bg-gradient-to-r from-violet-500/10 to-purple-500/10 text-violet-700 dark:text-violet-300 font-semibold border-r-2 border-violet-500'
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100/80 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100';
                    $parentIconClasses = $isGroupActive
                        ? 'text-violet-600 dark:text-violet-400'
                        : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300';
                @endphp

                <div x-data="{ ordersOpen: {{ $isGroupActive ? 'true' : 'false' }} }" :class="sidebarCollapsed ? 'relative' : ''">
                    {{-- Parent Toggle Button --}}
                    <button
                        @click="ordersOpen = !ordersOpen"
                        class="group relative flex w-full items-center rounded-xl py-3 text-sm smooth-animate {{ $parentLinkClasses }}"
                        :class="sidebarCollapsed ? 'justify-center px-0' : 'justify-between px-3'"
                        :aria-expanded="ordersOpen.toString()"
                    >
                        <div class="flex items-center" :class="sidebarCollapsed ? '' : 'gap-3'">
                            <svg class="h-5 w-5 shrink-0 transition-all duration-200 {{ $parentIconClasses }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="{{ $group['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="truncate font-medium">{{ $groupName }}</span>
                        </div>

                        <svg x-show="!sidebarCollapsed" class="h-4 w-4 shrink-0 transition-transform duration-200" :class="ordersOpen ? 'rotate-90' : 'rotate-0'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        {{-- Premium Tooltip for collapsed state --}}
                        <div x-show="sidebarCollapsed" class="premium-tooltip">{{ $groupName }}</div>
                    </button>

                    {{-- Collapsible Child Menu --}}
                    <div x-cloak
                        x-show="ordersOpen"
                        x-collapse.duration.300ms
                        class="mt-1 space-y-1 overflow-hidden smooth-animate"
                        :class="sidebarCollapsed ? 'absolute left-[var(--sidebar-mini)] top-0 w-64 p-2 bg-white/95 dark:bg-gray-800/95 border border-violet-200/50 dark:border-violet-700/30 rounded-xl shadow-2xl backdrop-smooth z-50' : ''"
                        @click.outside="sidebarCollapsed ? ordersOpen = false : null"
                    >
                        <div :class="sidebarCollapsed ? 'space-y-1' : 'ml-4 space-y-1 border-l border-violet-200/50 dark:border-violet-700/30 pl-3'">
                            @foreach($group['children'] as $childName => $childItem)
                                @php $childNav = nav_active($childItem['route']); @endphp
                                <a href="{{ url($childItem['route']) }}"
                                   class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm smooth-animate {{ $childNav['link'] }}"
                                   :class="sidebarCollapsed ? 'bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm' : ''">
                                    <svg class="h-4 w-4 shrink-0 transition-colors duration-200 {{ $childNav['is_active'] ? 'text-violet-600 dark:text-violet-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="{{ $childItem['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="truncate text-sm">{{ $childName }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- LOYALTY ITEMS --}}
            @foreach($loyalty_items as $name => $item)
                @php $nav = nav_active($item['route'].'*'); @endphp
                <a href="{{ url($item['route']) }}"
                   class="group relative flex items-center rounded-xl py-3 text-sm smooth-animate {{ $nav['link'] }}"
                   :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
                    <svg class="h-5 w-5 shrink-0 transition-all duration-200 {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="truncate font-medium">{{ $name }}</span>

                    {{-- Premium Tooltip for collapsed state --}}
                    <div x-show="sidebarCollapsed" class="premium-tooltip">{{ $name }}</div>
                </a>
            @endforeach
        </nav>

        {{-- Sidebar Footer --}}
        <div class="border-t border-violet-200/30 dark:border-violet-700/30 mt-auto" :class="sidebarCollapsed ? 'p-2' : 'p-4'">
            <div class="flex items-center rounded-xl bg-violet-50/50 dark:bg-violet-900/20 backdrop-blur-sm smooth-animate"
                 :class="sidebarCollapsed ? 'justify-center p-2' : 'gap-3 px-2 py-2'">
                <div class="h-9 w-9 shrink-0 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <div x-show="!sidebarCollapsed" x-transition.opacity.duration.300 class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $user->name ?? 'Admin' }}</p>
                    <p class="text-xs text-violet-600 dark:text-violet-400 truncate">{{ $user->role ?? 'Administrator' }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Header --}}
    <header class="fixed inset-x-0 top-0 z-30 h-[var(--header-h)] bg-white/80 dark:bg-gray-900/80 backdrop-smooth border-b border-violet-200/30 dark:border-violet-700/30 shadow-sm header-shell smooth-animate">
        <div class="h-full flex items-center gap-4 px-4 sm:px-6 lg:px-8">
            {{-- Mobile menu button --}}
            <div class="flex items-center gap-3 shrink-0">
                <button @click="mobileOpen = true" class="lg:hidden p-2 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-violet-100/50 dark:hover:bg-violet-900/30 smooth-animate" aria-label="Open sidebar menu">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round"/>
                    </svg>
                </button>

                {{-- Sidebar toggle --}}
                <button
                    @click="sidebarCollapsed = !sidebarCollapsed"
                    class="hidden lg:inline-flex items-center justify-center h-9 w-9 rounded-xl bg-white/80 dark:bg-gray-800/80 border border-violet-200/50 dark:border-violet-700/50 text-violet-600 dark:text-violet-400 hover:bg-violet-100/50 dark:hover:bg-violet-900/30 smooth-animate backdrop-blur-sm"
                    :title="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                >
                    <svg class="h-4 w-4 transition-transform duration-200" :class="sidebarCollapsed ? 'rotate-0' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            {{-- Search --}}
            <div class="flex-1 min-w-0"
                 x-data="{
                    query: '',
                    results: [],
                    open: false,
                    loading: false,
                    selected: -1,
                    debounceTimer: null,
                    search() {
                        clearTimeout(this.debounceTimer);
                        if (this.query.length < 2) { this.results = []; this.open = false; return; }
                        this.loading = true;
                        this.debounceTimer = setTimeout(() => {
                            fetch('{{ route('admin.search.suggestions') }}?q=' + encodeURIComponent(this.query), {
                                headers: { 'Accept': 'application/json' }
                            })
                            .then(r => r.json())
                            .then(data => {
                                this.results = data;
                                this.open = data.length > 0;
                                this.selected = -1;
                                this.loading = false;
                            })
                            .catch(() => { this.loading = false; });
                        }, 250);
                    },
                    navigate(e) {
                        if (!this.open) return;
                        if (e.key === 'ArrowDown') { e.preventDefault(); this.selected = Math.min(this.selected + 1, this.results.length - 1); }
                        if (e.key === 'ArrowUp') { e.preventDefault(); this.selected = Math.max(this.selected - 1, 0); }
                        if (e.key === 'Enter' && this.selected >= 0) { e.preventDefault(); window.location.href = this.results[this.selected].url; }
                        if (e.key === 'Escape') { this.open = false; }
                    },
                    go(url) { window.location.href = url; }
                 }"
                 @click.away="open = false"
                 @keydown="navigate($event)"
            >
                <div class="relative w-full max-w-2xl lg:mx-0">
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-violet-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.45 4.39l3.33 3.33a.75.75 0 1 1-1.06 1.06l-3.33-3.33A7 7 0 0 1 2 9Z"/>
                    </svg>
                    <input
                        type="search"
                        x-model="query"
                        @input="search()"
                        @focus="if (results.length) open = true"
                        class="block w-full rounded-2xl border border-violet-200/50 dark:border-violet-700/50 bg-white/50 dark:bg-gray-800/50 pl-10 pr-4 py-2.5 text-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:focus:ring-violet-500/30 text-gray-900 dark:text-gray-100 placeholder-violet-400 shadow-sm smooth-animate backdrop-blur-sm"
                        placeholder="Search products, orders, customers..."
                        aria-label="Search the dashboard content"
                        autocomplete="off"
                    />

                    {{-- Loading spinner --}}
                    <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-4 w-4 text-violet-400" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>

                    {{-- Suggestions dropdown --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute z-50 mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-violet-200/50 dark:border-violet-700/50 overflow-hidden max-h-[400px] overflow-y-auto">

                        <template x-for="(item, index) in results" :key="index">
                            <div @click="go(item.url)"
                                 :class="{ 'bg-violet-50 dark:bg-violet-900/30': selected === index }"
                                 class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-violet-50 dark:hover:bg-violet-900/30 transition-colors border-b border-gray-100 dark:border-gray-700/50 last:border-0"
                                 @mouseenter="selected = index">

                                {{-- Icon --}}
                                <div class="flex-shrink-0">
                                    <template x-if="item.icon === 'product'">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-violet-100 dark:bg-violet-900/50 text-violet-600 dark:text-violet-400">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </span>
                                    </template>
                                    <template x-if="item.icon === 'order'">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </span>
                                    </template>
                                    <template x-if="item.icon === 'customer'">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </span>
                                    </template>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate" x-text="item.title"></span>
                                        <span class="flex-shrink-0 px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide"
                                              :class="{
                                                  'bg-violet-100 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300': item.icon === 'product',
                                                  'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300': item.icon === 'order',
                                                  'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300': item.icon === 'customer'
                                              }"
                                              x-text="item.type"></span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5" x-text="item.meta"></p>
                                </div>

                                {{-- Arrow --}}
                                <svg class="flex-shrink-0 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </template>

                        {{-- No results --}}
                        <div x-show="results.length === 0 && query.length >= 2 && !loading" class="px-4 py-6 text-center text-sm text-gray-400">
                            No results found for "<span x-text="query" class="font-medium text-gray-600 dark:text-gray-300"></span>"
                        </div>
                    </div>
                </div>
            </div>

            {{-- Header actions --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- Notifications --}}
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        class="relative p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-100/50 dark:hover:bg-violet-900/30 smooth-animate"
                        aria-label="Notifications"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M14.857 17.082a23.85 23.85 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        @if(($unreadNotificationsCount ?? 0) > 0)
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full bg-red-500 text-[10px] font-bold text-white min-w-[18px]">
                                {{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}
                            </span>
                        @endif
                    </button>

                        {{-- Notifications dropdown --}}
                    <div
                        x-cloak
                        x-show="open"
                        @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                        class="absolute right-0 mt-2 w-72 sm:w-80 origin-top-right rounded-2xl bg-white/95 dark:bg-gray-800/95 shadow-2xl ring-1 ring-black/5 backdrop-smooth z-50 overflow-hidden"
                    >
                        {{-- Header --}}
                        <div class="px-4 py-3 border-b border-violet-200/30 dark:border-violet-700/30 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Notifications</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $unreadNotificationsCount }} unread
                                </p>
                            </div>

                            @if($unreadNotificationsCount > 0)
                            <form
                                method="POST"
                                action="{{ route('admin.notifications.mark-all-read') }}"
                                @click.stop
                            >
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="text-xs font-medium text-violet-600 hover:text-violet-800 dark:text-violet-400 dark:hover:text-violet-200"
                                >
                                    Mark all as read
                                </button>
                            </form>
                        @endif
                        </div>

                        {{-- List --}}
                        <div class="max-h-80 overflow-y-auto thin-scrollbar divide-y divide-violet-50 dark:divide-gray-700">
                            @forelse($recentNotifications as $notification)
                                @php
                                    $isUnread = is_null($notification->read_at);
                                    $data = $notification->data ?? [];
                                    $title = $data['title'] ?? class_basename($notification->type);
                                    $message = $data['message'] ?? ($data['body'] ?? 'You have a new notification.');
                                    $link = $data['url'] ?? null;
                                @endphp

                                @if($link)
                                    <a href="{{ $link }}"
                                    class="block px-4 py-3 hover:bg-violet-50/70 dark:hover:bg-violet-900/30 transition-colors">
                                @else
                                    <div class="px-4 py-3">
                                @endif
                                    <div class="flex items-start gap-3">
                                        {{-- Unread dot --}}
                                        <div class="mt-1">
                                            @if($isUnread)
                                                <span class="h-2.5 w-2.5 rounded-full bg-violet-500 inline-block"></span>
                                            @else
                                                <span class="h-2.5 w-2.5 rounded-full bg-gray-300 inline-block"></span>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                {{ $title }}
                                            </p>
                                            <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-300 line-clamp-2">
                                                {{ $message }}
                                            </p>
                                            <p class="mt-1 text-[11px] text-gray-400 dark:text-gray-500">
                                                {{ $notification->created_at?->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @if($link)
                                    </a>
                                @else
                                    </div>
                                @endif
                            @empty
                                <div class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>

                    </div>

                </div>

                {{-- User menu --}}
                <div x-data="{ userOpen: false }" class="relative">
                    <button @click="userOpen = !userOpen" class="flex items-center gap-3 p-1 rounded-2xl hover:bg-violet-100/50 dark:hover:bg-violet-900/30 smooth-animate pr-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user->name ?? 'Admin' }}</div>
                            <div class="text-xs text-violet-600 dark:text-violet-400">{{ $user->role ?? 'Store Manager' }}</div>
                        </div>
                        <div class="relative">
                            <img class="h-9 w-9 rounded-xl ring-2 ring-violet-500/30 object-cover smooth-animate" src="{{ asset('images/icons8-user-female-40.png') }}" alt="User Avatar">
                            <div class="absolute -inset-1 bg-violet-400/20 rounded-xl blur-sm -z-10"></div>
                        </div>
                    </button>

                    {{-- User dropdown --}}
                    <div x-cloak x-show="userOpen" @click.outside="userOpen = false" class="absolute right-0 mt-2 w-56 origin-top-right rounded-2xl bg-white/95 dark:bg-gray-800/95 shadow-2xl ring-1 ring-black/5 backdrop-smooth z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-violet-200/30 dark:border-violet-700/30">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $user->email ?? 'admin@example.com' }}</p>
                            <p class="text-xs text-violet-600 dark:text-violet-400 mt-0.5">{{ $user->role ?? 'Administrator' }}</p>
                        </div>
                        <a href="{{ url('admin/profile') }}" class="block px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-violet-50/50 dark:hover:bg-violet-900/20 smooth-animate">Your Profile</a>

                        {{-- Logout form with SweetAlert --}}
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="border-t border-violet-200/30 dark:border-violet-700/30">
                            @csrf
                            <button type="button" @click="confirmLogout(); userOpen = false" class="block w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50/50 dark:hover:bg-red-900/20 smooth-animate">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile sidebar overlay --}}
    <div x-cloak x-show="mobileOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click.self="mobileOpen=false"></div>

    {{-- Mobile sidebar --}}
        {{-- Mobile sidebar --}}
    <aside x-cloak x-show="mobileOpen"
           x-transition:enter="transition transform duration-300 ease-out"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition transform duration-200 ease-in"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-white/95 dark:bg-gray-800/95 border-r border-violet-200/50 dark:border-violet-700/50 shadow-2xl p-4 lg:hidden thin-scrollbar overflow-y-auto backdrop-smooth">
        <div class="flex h-14 items-center gap-3 px-2 mb-6 border-b border-violet-200/30 dark:border-violet-700/30 pb-4">
            <div class="relative">
                <img src="{{ asset('images/pawsitive-logo.jpg') }}" class="h-10 w-10 rounded-xl shadow-lg ring-2 ring-violet-300/50 dark:ring-violet-600/50" alt="Pawsitive Logo">
                <div class="absolute -inset-1 bg-violet-400/20 rounded-xl blur-sm -z-10"></div>
            </div>
            <span class="font-[Pacifico] text-2xl bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent dark:from-violet-400 dark:to-purple-400">{{ config('app.name') }}</span>
            <button @click="mobileOpen = false" class="ml-auto p-2 rounded-xl text-gray-500 dark:text-gray-300 hover:text-violet-700 dark:hover:text-violet-300 hover:bg-violet-100/50 dark:hover:bg-violet-900/30 smooth-animate" aria-label="Close sidebar menu">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="space-y-1">
            {{-- STANDARD NAV ITEMS --}}
            @foreach($nav_items as $name => $item)
                @php $nav = nav_active($item['route'].'*'); @endphp
                <a href="{{ url($item['route']) }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm smooth-animate {{ $nav['link'] }}"
                    @click="mobileOpen=false">
                    <svg class="h-5 w-5 shrink-0 transition-all duration-200 {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="font-medium">{{ $name }}</span>
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
                        ? 'bg-gradient-to-r from-violet-500/10 to-purple-500/10 text-violet-700 dark:text-violet-300 font-semibold border-r-2 border-violet-500'
                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100/80 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100';
                    $parentIconClasses = $isGroupActive
                        ? 'text-violet-600 dark:text-violet-400'
                        : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300';
                @endphp

                <div x-data="{ mobileOrdersOpen: {{ $isGroupActive ? 'true' : 'false' }} }">
                    {{-- Parent Toggle Button --}}
                    <button
                        @click="mobileOrdersOpen = !mobileOrdersOpen"
                        class="group flex w-full items-center rounded-xl px-3 py-3 text-sm smooth-animate {{ $parentLinkClasses }} justify-between"
                        :aria-expanded="mobileOrdersOpen.toString()"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 transition-all duration-200 {{ $parentIconClasses }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="{{ $group['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="font-medium">{{ $groupName }}</span>
                        </div>
                        {{-- Chevron Icon --}}
                        <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="mobileOrdersOpen ? 'rotate-90' : 'rotate-0'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    {{-- Collapsible Child Menu --}}
                    <div x-cloak
                        x-show="mobileOrdersOpen"
                        x-collapse.duration.300ms
                        class="mt-1 space-y-1 overflow-hidden ml-4 border-l border-violet-200/50 dark:border-violet-700/30 pl-3"
                    >
                        @foreach($group['children'] as $childName => $childItem)
                            @php $childNav = nav_active($childItem['route']); @endphp
                            <a href="{{ url($childItem['route']) }}"
                               class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm smooth-animate {{ $childNav['link'] }}"
                               @click="mobileOpen=false">
                                <svg class="h-4 w-4 shrink-0 transition-colors duration-200 {{ $childNav['is_active'] ? 'text-violet-600 dark:text-violet-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="{{ $childItem['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-sm">{{ $childName }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- LOYALTY ITEMS --}}
            @foreach($loyalty_items as $name => $item)
                @php $nav = nav_active($item['route'].'*'); @endphp
                <a href="{{ url($item['route']) }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm smooth-animate {{ $nav['link'] }}"
                    @click="mobileOpen=false">
                    <svg class="h-5 w-5 shrink-0 transition-all duration-200 {{ $nav['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="{{ $item['icon'] }}" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="font-medium">{{ $name }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Mobile sidebar footer --}}
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-violet-200/30 dark:border-violet-700/30 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm">
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl bg-violet-50/50 dark:bg-violet-900/20">
                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $user->name ?? 'Admin' }}</p>
                    <p class="text-xs text-violet-600 dark:text-violet-400 truncate">{{ $user->role ?? 'Administrator' }}</p>
                </div>
                {{-- Logout button in mobile --}}
                <button @click="confirmLogout(); mobileOpen = false"
                        class="p-2 rounded-xl text-red-600 dark:text-red-400 hover:bg-red-50/50 dark:hover:bg-red-900/20 smooth-animate"
                        title="Sign out">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                </button>
            </div>
        </div>
    </aside>


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
                    window.addEventListener('toast', e => this.fire(e.detail.message, e.detail.type ?? 'success'));
                    @if (session('success'))
                        this.fire(@js(session('success')), 'success');
                    @endif
                    @if (session('error'))
                        this.fire(@js(session('error')), 'error');
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
<x-session-timeout />
</body>
</html>
