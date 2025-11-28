<x-admin-layout>
    {{-- Page Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Change max-width to full width --}}
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. General Profile Information --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- Removed max-w-xl to allow full width usage within the padding --}}
                <div class="w-full">
                    <section>
                        <header>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('General Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        {{-- Success Status Message (Placeholder for Laravel session messages) --}}
                        @if (session('status') === 'profile-updated')
                            <div 
                                x-data="{ show: true }" 
                                x-show="show" 
                                x-transition 
                                x-init="setTimeout(() => show = false, 3000)"
                                class="mt-4 p-3 rounded-lg text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/50"
                            >
                                {{ __('Saved.') }}
                            </div>
                        @endif

                        {{-- Profile Update Form --}}
                        <form method="POST" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            {{-- Removed Profile Picture and ID/Role Section --}}
                            
                            {{-- First Name & Last Name --}}
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

                            <div class="flex justify-end pt-4">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-base font-semibold shadow-md transition duration-150">
                                    {{ __('Save Information') }}
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- 2. Update Password --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                {{-- Removed max-w-xl to allow full width usage within the padding --}}
                <div class="w-full">
                    <section>
                        <header>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('Update Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                         {{-- Success Status Message (Placeholder for Laravel session messages) --}}
                        @if (session('status') === 'password-updated')
                            <div 
                                x-data="{ show: true }" 
                                x-show="show" 
                                x-transition 
                                x-init="setTimeout(() => show = false, 3000)"
                                class="mt-4 p-3 rounded-lg text-sm text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-800/50"
                            >
                                {{ __('Password Saved.') }}
                            </div>
                        @endif

                        {{-- Password Update Form --}}
                        <form method="POST" action="{{ route('admin.password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')

                             {{-- Current Password --}}
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Current Password 
                                </label>
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('current_password') border-red-500 @enderror"
                                    required
                                    autocomplete="current-password"
                                >
                                @error('current_password')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>


                            {{-- New Password & Confirmation --}}
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
                                        required
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
                                        required
                                    >
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-base font-semibold shadow-md transition duration-150">
                                    {{ __('Update Password') }}
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
            
        </div>
    </div>
</x-admin-layout>