<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Profile') }}
        </h2>
    </x-slot>

    <div class="space-y-6">

        {{-- 1. General Profile Information --}}
        <div class="p-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
            <header class="mb-5">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ __('General Information') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </header>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="mb-5 p-3 rounded-lg text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/50"
                >
                    {{ __('Saved.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="fname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">First Name</label>
                        <input type="text" id="fname" name="fname" value="{{ old('fname', $user->fname) }}" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('fname') border-red-500 @enderror">
                        @error('fname') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="lname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Name</label>
                        <input type="text" id="lname" name="lname" value="{{ old('lname', $user->lname) }}" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('lname') border-red-500 @enderror">
                        @error('lname') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('username') border-red-500 @enderror">
                        @error('username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('email') border-red-500 @enderror">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition">
                        {{ __('Save Information') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- 2. Two-Factor Authentication --}}
        <div class="p-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
            <header class="mb-5">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Two-Factor Authentication') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Add an extra layer of security to your account using a TOTP authenticator app.') }}
                </p>
            </header>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="mb-5 p-3 rounded-lg text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/50">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                    class="mb-5 p-3 rounded-lg text-sm text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-800/50">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('recovery_codes'))
                <div class="mb-5 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50">
                    <div class="flex items-start gap-3 mb-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                            Save these recovery codes in a secure location. They can be used to access your account if you lose your authenticator device.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                        @foreach (session('recovery_codes') as $code)
                            <div class="px-3 py-2 bg-white dark:bg-gray-700 rounded-lg text-center">
                                <code class="text-xs font-mono font-semibold text-gray-800 dark:text-gray-200 select-all">{{ $code }}</code>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($user->two_factor_confirmed_at)
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-green-700 dark:text-green-400">Two-factor authentication is enabled</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Your account is protected with TOTP-based 2FA.</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.two-factor.recovery-codes') }}"
                        class="inline-flex items-center px-4 py-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-sm font-medium text-gray-700 dark:text-gray-300 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/>
                        </svg>
                        View Recovery Codes
                    </a>

                    <div x-data="{ showDisable: false }">
                        <button @click="showDisable = !showDisable" type="button"
                            class="inline-flex items-center px-4 py-2.5 rounded-xl bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 text-sm font-medium text-red-700 dark:text-red-400 border border-red-200 dark:border-red-700/50 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            Disable 2FA
                        </button>

                        <div x-show="showDisable" x-transition class="mt-4 p-4 bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-200 dark:border-red-700/50">
                            <p class="text-sm text-red-700 dark:text-red-300 mb-3">Enter a code from your authenticator app to confirm disabling 2FA:</p>
                            <form method="POST" action="{{ route('admin.two-factor.disable') }}" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3">
                                @csrf
                                @method('DELETE')
                                <div class="flex-1">
                                    <input type="text" name="code" maxlength="6" inputmode="numeric" pattern="[0-9]*" placeholder="000000" required
                                        class="w-full rounded-xl border-red-300 dark:border-red-600 dark:bg-gray-700 dark:text-gray-100 focus:border-red-500 focus:ring-red-500 text-center text-lg tracking-widest font-mono">
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold shadow-md transition">
                                    Confirm Disable
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Two-factor authentication is not enabled</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Enable 2FA for enhanced account security.</p>
                    </div>
                </div>

                <a href="{{ route('admin.two-factor.setup') }}"
                    class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    {{ __('Enable Two-Factor Authentication') }}
                </a>
            @endif
        </div>

        {{-- 3. Security Monitoring Overview --}}
        <div class="p-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
            <header class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                        {{ __('Security Monitoring') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Monitor suspicious activity and security status across the platform.') }}
                    </p>
                </div>
                <a href="{{ route('admin.security-monitoring') }}"
                    class="inline-flex items-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow transition shrink-0 self-start">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                    </svg>
                    Full Dashboard
                </a>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Recent Logins --}}
                <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">{{ number_format($recentLogins) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Logins (7 days)</p>
                    </div>
                </div>

                {{-- Suspicious --}}
                <div class="flex items-center gap-3 p-4 rounded-xl {{ $suspiciousLogins > 0 ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700' : 'bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600' }}">
                    <div class="w-10 h-10 rounded-xl {{ $suspiciousLogins > 0 ? 'bg-red-100 dark:bg-red-900/40' : 'bg-emerald-100 dark:bg-emerald-900/40' }} flex items-center justify-center shrink-0">
                        @if($suspiciousLogins > 0)
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        @else
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-xl font-bold {{ $suspiciousLogins > 0 ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-white' }}">{{ number_format($suspiciousLogins) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Suspicious (30 days)</p>
                    </div>
                </div>

                {{-- Blocked --}}
                <div class="flex items-center gap-3 p-4 rounded-xl {{ $blockedAccounts > 0 ? 'bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700' : 'bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600' }}">
                    <div class="w-10 h-10 rounded-xl {{ $blockedAccounts > 0 ? 'bg-amber-100 dark:bg-amber-900/40' : 'bg-gray-100 dark:bg-gray-700' }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 {{ $blockedAccounts > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold {{ $blockedAccounts > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-800 dark:text-white' }}">{{ $blockedAccounts }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Blocked Accounts</p>
                    </div>
                </div>
            </div>

            {{-- Recent Suspicious Activity --}}
            @if($recentSuspiciousActivity->isNotEmpty())
                <div class="mt-5">
                    <h3 class="text-sm font-semibold text-red-700 dark:text-red-400 mb-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                        Recent Suspicious Activity
                    </h3>
                    <div class="space-y-2">
                        @foreach($recentSuspiciousActivity as $activity)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-800/30">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                            {{ $activity->user ? $activity->user->fname . ' ' . $activity->user->lname : 'Deleted User' }}
                                        </p>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                            <span class="font-mono">{{ $activity->ip_address }}</span>
                                            <span class="hidden sm:inline">&middot;</span>
                                            <span class="hidden sm:inline">{{ $activity->browser }} / {{ $activity->platform }}</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap shrink-0">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-5 p-3.5 rounded-xl bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/30 flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300">No suspicious activity detected. All clear!</p>
                </div>
            @endif
        </div>

        {{-- 4. Update Password --}}
        <div class="p-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-xl">
            <header class="mb-5">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ __('Update Password') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </header>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="mb-5 p-3 rounded-lg text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/50"
                >
                    {{ __('Password Saved.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required autocomplete="current-password"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('current_password') border-red-500 @enderror">
                    @error('current_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('password') border-red-500 @enderror">
                        @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition">
                        {{ __('Update Password') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
