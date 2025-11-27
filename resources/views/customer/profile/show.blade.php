<x-app-layout>
    <div class="py-10 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            {{--
                FIX APPLIED:
                Removed 'max-w-6xl' to make the container fluid (full width).
                Retained 'w-full mx-auto px-4 sm:px-6 lg:px-8' for responsive padding.
            --}}

            {{-- PAGE TITLE --}}
            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">
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
                        
                        {{-- User Header (Improved) --}}
                        <div class="pb-4 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                {{ $user->fname }} {{ $user->lname }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Customer ID: <span class="font-mono text-gray-700 dark:text-gray-300">{{ $user->id }}</span>
                            </p>
                        </div>

                        <nav class="space-y-1 text-sm">
                            
                            {{-- Dashboard --}}
                            <a href="{{ route('customer.shop') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                               {{ $current === 'customer.shop' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>
                                <span>Dashboard</span>
                            </a>

                            {{-- History (Order History) --}}
                            @if (\Illuminate\Support\Facades\Route::has('customer.orders.index'))
                                <a href="{{ route('customer.orders.index') }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                                   {{ str_starts_with($current, 'customer.orders.') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Order History</span>
                                </a>
                            @else
                                <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-400 dark:text-gray-500 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m5-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Order History (coming soon)</span>
                                </div>
                            @endif

                            {{-- Profile (Active Link) --}}
                            <a href="{{ route('customer.profile') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                               {{ $current === 'customer.profile' ? 'bg-indigo-600 text-white shadow-md font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A10.97 10.97 0 0112 15c2.21 0 4.267.64 5.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Profile</span>
                            </a>
                            
                            {{-- Logout Link (Added for completeness) --}}
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

                {{-- MAIN CONTENT (PROFILE FORM) --}}
                <section class="md:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b pb-3">
                            Account Details
                        </h2>

                        @if (session('success'))
                            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 dark:bg-green-900/40 dark:text-green-300 rounded-lg" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                
                                {{-- First Name --}}
                                <div>
                                    <label for="fname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        First Name
                                    </label>
                                    <input
                                        type="text"
                                        id="fname"
                                        name="fname"
                                        value="{{ old('fname', $user->fname) }}"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('fname') border-red-500 @enderror"
                                        required
                                    >
                                    @error('fname')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Last Name --}}
                                <div>
                                    <label for="lname" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Last Name
                                    </label>
                                    <input
                                        type="text"
                                        id="lname"
                                        name="lname"
                                        value="{{ old('lname', $user->lname) }}"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('lname') border-red-500 @enderror"
                                        required
                                    >
                                    @error('lname')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Username & Email --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Username
                                    </label>
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        value="{{ old('username', $user->username) }}"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('username') border-red-500 @enderror"
                                        required
                                    >
                                    @error('username')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('email') border-red-500 @enderror"
                                        required
                                    >
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white pt-4 border-t border-gray-200 dark:border-gray-700">
                                Update Password
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                                Leave these fields blank if you do not wish to change your password.
                            </p>


                            {{-- Password --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        New Password 
                                    </label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('password') border-red-500 @enderror"
                                        autocomplete="new-password"
                                    >
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Confirm New Password
                                    </label>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        autocomplete="new-password"
                                    >
                                </div>
                                {{-- Password confirmation error is handled by the 'password' field error above --}}
                            </div>

                            <div class="flex justify-end pt-4">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-base font-semibold shadow-md transition duration-150">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>