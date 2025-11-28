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
                {{-- History (Order History) --}}
                @if (\Illuminate\Support\Facades\Route::has('customer.profile.transactions'))
                    <a href="{{ route('customer.profile.transactions') }}"
                       class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                                   {{ str_starts_with($current, 'customer.profile.transactions') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
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
                Transaction List
            </h2>

            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 dark:bg-green-900/40 dark:text-green-300 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($transactions as $transaction)

            @endforeach
        </div>
    </section>
</div>
</div>
</div>
</x-app-layout>
