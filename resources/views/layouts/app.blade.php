<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @stack('styles')
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 ">
            @include('layouts.navigation')


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white  shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @include('layouts.footer')
        @if(!request()->routeIs('customer.shop'))
            @include('components.chat-widget')
        @endif

        @if(session('welcome_user'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hour = new Date().getHours();
            let greeting = 'Good evening';
            let emoji = '🌙';
            if (hour < 12) { greeting = 'Good morning'; emoji = '☀️'; }
            else if (hour < 18) { greeting = 'Good afternoon'; emoji = '🌤️'; }

            Swal.fire({
                html: `
                    <div style="position:relative; padding: 0;">
                        <div style="background: linear-gradient(135deg, #8a2be2 0%, #6a0dad 50%, #4c1d95 100%); padding: 40px 30px 50px; border-radius: 16px 16px 0 0; margin: -1.5em -1.5em 0; position: relative; overflow: hidden;">
                            <div style="position:absolute; top:-20px; right:-20px; width:120px; height:120px; background:rgba(255,255,255,0.08); border-radius:50%;"></div>
                            <div style="position:absolute; bottom:-30px; left:-15px; width:80px; height:80px; background:rgba(249,223,113,0.15); border-radius:50%;"></div>
                            <div style="position:absolute; top:15px; left:20px; width:40px; height:40px; background:rgba(255,255,255,0.05); border-radius:50%;"></div>
                            <div style="position:relative; z-index:1; text-align:center;">
                                <div style="font-size:48px; margin-bottom:12px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">🐾</div>
                                <p style="color:rgba(255,255,255,0.7); font-size:13px; text-transform:uppercase; letter-spacing:3px; font-weight:600; margin-bottom:8px;">
                                    ${emoji} ${greeting}
                                </p>
                                <h2 style="font-family: 'Quicksand', sans-serif; font-size:28px; font-weight:800; color:#fff; margin:0; text-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                                    {{ session('welcome_user') }}!
                                </h2>
                            </div>
                        </div>
                        <div style="padding: 24px 20px 10px; text-align:center;">
                            <p style="color:#555; font-size:15px; margin-bottom:16px; line-height:1.5;">
                                Welcome back to <strong style="color:#8a2be2;">{{ config('app.name') }}</strong>
                            </p>
                            <div style="display:flex; justify-content:center; gap:8px; flex-wrap:wrap;">
                                <span style="background:linear-gradient(135deg,#f3e8ff,#ede9fe); color:#7c3aed; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid #e9d5ff;">🛍️ Happy Shopping!</span>
                                <span style="background:linear-gradient(135deg,#fff9e6,#fef3c7); color:#b45309; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid #fde68a;">✨ New Arrivals</span>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                timer: 5000,
                timerProgressBar: true,
                width: 420,
                padding: 0,
                background: '#fff',
                backdrop: 'rgba(0,0,0,0.4)',
                didOpen: (popup) => {
                    const closeBtn = popup.querySelector('.swal2-close');
                    if (closeBtn) {
                        closeBtn.style.position = 'absolute';
                        closeBtn.style.top = '10px';
                        closeBtn.style.right = '10px';
                        closeBtn.style.zIndex = '10';
                        closeBtn.style.color = 'rgba(255,255,255,0.7)';
                        closeBtn.style.fontSize = '28px';
                    }
                    const bar = popup.querySelector('.swal2-timer-progress-bar');
                    if (bar) bar.style.background = '#8a2be2';
                },
            });
        });
        </script>
        @endif
    <x-session-timeout />
    </body>
</html>
