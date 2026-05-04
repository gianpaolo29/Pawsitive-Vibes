<x-app-layout>
    <div class="py-10 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">

            {{-- PAGE TITLE --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">
                    Account Settings
                </h1>
                <p class="mt-1 text-base text-gray-500 dark:text-gray-400">
                    Manage your profile, login credentials, and view your activity.
                </p>
            </div>

            @php
                $current = \Illuminate\Support\Facades\Route::currentRouteName();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- LEFT NAV --}}
                <aside class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-4">

                        {{-- User Header --}}
                        <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $user->fname }} {{ $user->lname }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Customer ID: <span class="font-mono text-gray-700 dark:text-gray-300">{{ $user->id }}</span>
                            </p>
                        </div>

                        <nav class="space-y-1 text-sm">
                            {{-- Profile --}}
                            <a href="{{ route('customer.profile') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                               {{ $current === 'customer.profile' ? 'bg-indigo-600 text-white shadow-md font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A10.97 10.97 0 0112 15c2.21 0 4.267.64 5.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Profile</span>
                            </a>

                            {{-- Order History --}}
                            @if (\Illuminate\Support\Facades\Route::has('customer.profile.transactions'))
                                <a href="{{ route('customer.profile.transactions') }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                                   {{ str_starts_with($current, 'customer.profile.transactions') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Order History</span>
                                </a>
                            @endif

                            {{-- Login Activity --}}
                            <a href="{{ route('customer.profile.login-activity') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                               {{ $current === 'customer.profile.login-activity' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                <span>Login Activity</span>
                            </a>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}" class="w-full pt-2">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-3 py-2 w-full text-left rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/40 transition duration-150 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </aside>

                {{-- MAIN CONTENT --}}
                <section class="md:col-span-3 space-y-6">

                    {{-- Stats Cards --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Total Logins --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalLogins }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Total Logins</p>
                                </div>
                            </div>
                        </div>

                        {{-- Unique IPs --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $uniqueIps }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Unique IPs</p>
                                </div>
                            </div>
                        </div>

                        {{-- Suspicious --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border {{ $suspiciousCount > 0 ? 'border-red-200 dark:border-red-700' : 'border-gray-200 dark:border-gray-700' }} p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $suspiciousCount > 0 ? 'bg-red-100 dark:bg-red-900/40' : 'bg-emerald-100 dark:bg-emerald-900/40' }} flex items-center justify-center">
                                    @if($suspiciousCount > 0)
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                    @else
                                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-2xl font-bold {{ $suspiciousCount > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-white' }}">{{ $suspiciousCount }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Suspicious</p>
                                </div>
                            </div>
                        </div>

                        {{-- Last Login --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $lastLogin ? $lastLogin->created_at->diffForHumans() : 'Never' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Last Login</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Suspicious Activity Alert --}}
                    @if($suspiciousCount > 0)
                        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-red-800 dark:text-red-300">Suspicious Activity Detected</h3>
                                    <p class="text-sm text-red-700 dark:text-red-400 mt-1">
                                        We detected {{ $suspiciousCount }} suspicious login(s) on your account. This happens when logins occur from multiple different locations in a short period. If you don't recognize these logins, please change your password and enable two-factor authentication immediately.
                                    </p>
                                    <div class="flex gap-2 mt-3">
                                        <a href="{{ route('customer.profile') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                                            Change Password
                                        </a>
                                        @if(!$user->two_factor_confirmed_at)
                                            <a href="{{ route('customer.profile.two-factor.setup') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold bg-white dark:bg-gray-800 text-red-700 dark:text-red-400 border border-red-300 dark:border-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                                                Enable 2FA
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Login History Table --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                Login History
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Review all login sessions for your account. Suspicious logins are highlighted.
                            </p>
                        </div>

                        @if($loginLogs->isEmpty())
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No login activity yet</h3>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Your login history will appear here after your first login.</p>
                            </div>
                        @else
                            {{-- Mobile Cards --}}
                            <div class="block md:hidden divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($loginLogs as $log)
                                    <div class="p-4 {{ $log->is_suspicious ? 'bg-red-50/50 dark:bg-red-900/10' : '' }}">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                {{-- Device Icon --}}
                                                @if($log->device === 'Mobile')
                                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                                    </div>
                                                @elseif($log->device === 'Tablet')
                                                    <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"/></svg>
                                                    </div>
                                                @else
                                                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $log->browser }} on {{ $log->platform }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->device }}</p>
                                                </div>
                                            </div>
                                            @if($log->is_suspicious)
                                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 uppercase">Suspicious</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                            <span class="font-mono">{{ $log->ip_address }}</span>
                                            <span>{{ $log->created_at->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Desktop Table --}}
                            <div class="hidden md:block overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Device</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Browser</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Platform</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                        @foreach($loginLogs as $log)
                                            <tr class="{{ $log->is_suspicious ? 'bg-red-50/50 dark:bg-red-900/10' : 'hover:bg-gray-50/50 dark:hover:bg-gray-700/30' }} transition-colors">
                                                {{-- Device --}}
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-2">
                                                        @if($log->device === 'Mobile')
                                                            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                                            </div>
                                                        @elseif($log->device === 'Tablet')
                                                            <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"/></svg>
                                                            </div>
                                                        @else
                                                            <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                                                            </div>
                                                        @endif
                                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $log->device }}</span>
                                                    </div>
                                                </td>

                                                {{-- Browser --}}
                                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $log->browser }}</td>

                                                {{-- Platform --}}
                                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $log->platform }}</td>

                                                {{-- IP Address --}}
                                                <td class="px-6 py-4">
                                                    <span class="text-sm font-mono text-gray-600 dark:text-gray-400">{{ $log->ip_address }}</span>
                                                </td>

                                                {{-- Status --}}
                                                <td class="px-6 py-4">
                                                    @if($log->is_suspicious)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                                            Suspicious
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                            Normal
                                                        </span>
                                                    @endif
                                                </td>

                                                {{-- Date --}}
                                                <td class="px-6 py-4">
                                                    <div>
                                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $log->created_at->format('M d, Y') }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->created_at->format('h:i A') }} &middot; {{ $log->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination --}}
                            @if($loginLogs->hasPages())
                                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                                    {{ $loginLogs->links() }}
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Security Tips --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/></svg>
                            Security Tips
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Strong Password</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Use a unique password with letters, numbers, and symbols.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Enable 2FA</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Two-factor authentication protects against unauthorized access.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">Review Activity</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Check your login history regularly for unfamiliar sessions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
