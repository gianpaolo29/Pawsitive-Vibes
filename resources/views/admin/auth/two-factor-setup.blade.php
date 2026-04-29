<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Set Up Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-violet-100 dark:bg-violet-900/30 mb-4">
                        <svg class="w-8 h-8 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Scan QR Code
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Scan the QR code below with your authenticator app (Google Authenticator, Authy, etc.), then enter the 6-digit code to confirm.
                    </p>
                </div>

                {{-- QR Code --}}
                <div class="flex justify-center my-6">
                    <div class="p-4 bg-white rounded-xl shadow-inner border border-gray-200">
                        {!! $qrSvg !!}
                    </div>
                </div>

                {{-- Manual secret --}}
                <div class="text-center mb-6">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Or enter this code manually:</p>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <code class="text-sm font-mono font-bold text-violet-700 dark:text-violet-300 tracking-widest select-all">{{ $secret }}</code>
                    </div>
                </div>

                {{-- Confirm Code Form --}}
                <form method="POST" action="{{ route('admin.two-factor.confirm') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Verification Code
                        </label>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            maxlength="6"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            autocomplete="one-time-code"
                            autofocus
                            required
                            placeholder="000000"
                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-violet-500 focus:ring-violet-500 text-center text-2xl tracking-[0.5em] font-mono @error('code') border-red-500 @enderror"
                        >
                        @error('code')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 rounded-xl bg-violet-600 hover:bg-violet-700 text-white text-base font-semibold shadow-md transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Confirm & Enable 2FA
                        </button>
                        <a href="{{ route('admin.profile') }}"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 text-base font-semibold transition duration-150">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
