<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Security Monitoring') }}
            </h2>
            <a href="{{ route('admin.profile') }}" class="inline-flex items-center gap-1.5 text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Filters & Export --}}
        <div class="p-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                <form method="GET" action="{{ route('admin.security-monitoring') }}" class="flex flex-wrap items-end gap-3">
                    <div>
                        <label for="date_from" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">From</label>
                        <input type="date" id="date_from" name="date_from" value="{{ $dateFrom }}"
                            class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="date_to" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">To</label>
                        <input type="date" id="date_to" name="date_to" value="{{ $dateTo }}"
                            class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="filter" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Filter</label>
                        <select id="filter" name="filter"
                            class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>All Activity</option>
                            <option value="suspicious" {{ $filter === 'suspicious' ? 'selected' : '' }}>Suspicious Only</option>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Search</label>
                        <input type="text" id="search" name="search" value="{{ $searchQuery }}" placeholder="IP, name, email..."
                            class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Apply
                    </button>
                </form>

                {{-- Export --}}
                <div x-data="{ open: false }" class="relative shrink-0">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export Report
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-gray-700 shadow-lg border border-gray-200 dark:border-gray-600 z-50 py-1 overflow-hidden">
                        <a href="{{ route('admin.security-monitoring.export', ['type' => 'all', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            All Login Activity
                        </a>
                        <a href="{{ route('admin.security-monitoring.export', ['type' => 'suspicious', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <svg class="w-4 h-4 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            Suspicious Activity Only
                        </a>
                        <a href="{{ route('admin.security-monitoring.export', ['type' => 'blocked', 'date_from' => $dateFrom, 'date_to' => $dateTo]) }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                            <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            Blocked Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            @php
                $stats = [
                    ['label' => 'Total Logins',    'value' => number_format($totalLogins),    'color' => 'indigo',  'icon' => 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9', 'alert' => false],
                    ['label' => 'Suspicious',       'value' => number_format($suspiciousLogins), 'color' => $suspiciousLogins > 0 ? 'red' : 'emerald', 'icon' => $suspiciousLogins > 0 ? 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z' : 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z', 'alert' => $suspiciousLogins > 0],
                    ['label' => 'Blocked Accounts', 'value' => $blockedAccounts,              'color' => $blockedAccounts > 0 ? 'amber' : 'gray',    'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'alert' => $blockedAccounts > 0],
                    ['label' => 'Unique IPs',       'value' => number_format($uniqueIps),     'color' => 'blue',    'icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418', 'alert' => false],
                    ['label' => 'Total Customers',  'value' => number_format($totalUsers),    'color' => 'violet',  'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'alert' => false],
                    ['label' => 'Without 2FA',      'value' => number_format($usersWithout2FA),'color' => $usersWithout2FA > 0 ? 'orange' : 'emerald','icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'alert' => $usersWithout2FA > 0],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow border {{ $stat['alert'] ? 'border-'.$stat['color'].'-200 dark:border-'.$stat['color'].'-700' : 'border-gray-200 dark:border-gray-700' }} p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/40 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xl font-bold {{ $stat['alert'] ? 'text-'.$stat['color'].'-600 dark:text-'.$stat['color'].'-400' : 'text-gray-800 dark:text-white' }} truncate">{{ $stat['value'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Three-Column Panels --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            {{-- Blocked Users --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                        Blocked Users
                    </h3>
                </div>
                <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($blockedUsers as $blocked)
                        <div class="px-5 py-3">
                            <div class="flex items-center justify-between gap-2 mb-0.5">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $blocked->fname }} {{ $blocked->lname }}</p>
                                @if($blocked->blocked_until)
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded-full shrink-0 {{ $blocked->blocked_until->isFuture() ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $blocked->blocked_until->isFuture() ? 'Until ' . $blocked->blocked_until->format('M d, h:i A') : 'Expired' }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 shrink-0">Permanent</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $blocked->email }}</p>
                            <p class="text-xs text-red-600 dark:text-red-400 mt-1 truncate" title="{{ $blocked->blocked_reason }}">{{ $blocked->blocked_reason }}</p>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <svg class="w-8 h-8 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No blocked users</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Top Suspicious IPs --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        Top Suspicious IPs
                    </h3>
                </div>
                <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($topSuspiciousIps as $ip)
                        <div class="px-5 py-3 flex items-center justify-between gap-2">
                            <span class="text-sm font-mono text-gray-700 dark:text-gray-300 truncate">{{ $ip->ip_address }}</span>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 shrink-0">
                                {{ $ip->count }} {{ Str::plural('hit', $ip->count) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <svg class="w-8 h-8 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No suspicious IPs detected</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Suspicious Logins --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Recent Suspicious Logins
                    </h3>
                </div>
                <div class="max-h-72 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($suspiciousActivity->take(15) as $activity)
                        <div class="px-5 py-3">
                            <div class="flex items-center justify-between gap-2 mb-0.5">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                    {{ $activity->user ? $activity->user->fname . ' ' . $activity->user->lname : 'Deleted User' }}
                                </p>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="font-mono">{{ $activity->ip_address }}</span>
                                <span class="hidden sm:inline">&middot;</span>
                                <span class="hidden sm:inline truncate">{{ $activity->browser }} &middot; {{ $activity->device }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center">
                            <svg class="w-8 h-8 text-emerald-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No suspicious activity</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Login Activity Table --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    Login Activity Log
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    All login sessions across the platform. Showing {{ $dateFrom }} to {{ $dateTo }}.
                </p>
            </div>

            @if($loginLogs->isEmpty())
                <div class="px-5 py-16 text-center">
                    <div class="w-14 h-14 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">No login activity found</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Try adjusting the date range or filters.</p>
                </div>
            @else
                {{-- Mobile Cards --}}
                <div class="block lg:hidden divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($loginLogs as $log)
                        <div class="px-5 py-3.5 {{ $log->is_suspicious ? 'bg-red-50/50 dark:bg-red-900/10' : '' }}">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                        {{ $log->user ? $log->user->fname . ' ' . $log->user->lname : 'Deleted User' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $log->user?->email }}</p>
                                </div>
                                @if($log->is_suspicious)
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 uppercase shrink-0">Suspicious</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 text-xs text-gray-500 dark:text-gray-400">
                                <span class="font-mono">{{ $log->ip_address }}</span>
                                <span>{{ $log->browser }} / {{ $log->platform }}</span>
                                <span>{{ $log->device }}</span>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop Table --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Device</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Browser</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Platform</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($loginLogs as $log)
                                <tr class="{{ $log->is_suspicious ? 'bg-red-50/50 dark:bg-red-900/10' : 'hover:bg-gray-50/50 dark:hover:bg-gray-700/30' }} transition-colors">
                                    <td class="px-5 py-3.5">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $log->user ? $log->user->fname . ' ' . $log->user->lname : 'Deleted User' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->user?->email }}</p>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="text-sm font-mono text-gray-600 dark:text-gray-400">{{ $log->ip_address }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2">
                                            @php
                                                $deviceColor = match($log->device) {
                                                    'Mobile' => 'blue',
                                                    'Tablet' => 'purple',
                                                    default  => 'gray',
                                                };
                                            @endphp
                                            <div class="w-7 h-7 rounded-lg bg-{{ $deviceColor }}-100 dark:bg-{{ $deviceColor }}-900/40 flex items-center justify-center shrink-0">
                                                @if($log->device === 'Mobile')
                                                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></svg>
                                                @elseif($log->device === 'Tablet')
                                                    <svg class="w-3.5 h-3.5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"/></svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/></svg>
                                                @endif
                                            </div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $log->device }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-sm text-gray-700 dark:text-gray-300">{{ $log->browser }}</td>
                                    <td class="px-5 py-3.5 text-sm text-gray-700 dark:text-gray-300">{{ $log->platform }}</td>
                                    <td class="px-5 py-3.5">
                                        @if($log->is_suspicious)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                                Suspicious
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                                Normal
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $log->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->created_at->format('h:i A') }} &middot; {{ $log->created_at->diffForHumans() }}</p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($loginLogs->hasPages())
                    <div class="px-5 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $loginLogs->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</x-admin-layout>
