<x-app-layout>
    <div class="py-10 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-lg mx-auto px-4">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-8 text-center">
                    <div class="text-4xl mb-3">🔐</div>
                    <h1 class="text-2xl font-bold text-white">Set Up Two-Factor Authentication</h1>
                    <p class="text-indigo-200 text-sm mt-2">Scan the QR code with your authenticator app</p>
                </div>

                <div class="p-4 md:p-6 space-y-6">
                    {{-- Step 1 --}}
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-7 h-7 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-xs font-bold text-indigo-700 dark:text-indigo-300">1</span>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Scan QR Code</h3>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Open <strong>Google Authenticator</strong>, <strong>Authy</strong>, or any TOTP app and scan this QR code.
                        </p>
                        <div class="flex justify-center">
                            <div class="bg-white rounded-xl p-3 shadow-md border-2 border-gray-100 inline-block w-48 h-48 sm:w-60 sm:h-60">
                                {!! $qrSvg !!}
                            </div>
                        </div>
                    </div>

                    {{-- Manual Key --}}
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Can't scan? Enter this key manually:</p>
                        <div class="bg-white dark:bg-gray-800 rounded-lg px-4 py-3 font-mono text-xs sm:text-sm font-bold text-indigo-700 dark:text-indigo-400 tracking-wider sm:tracking-widest break-all text-center select-all border border-gray-200 dark:border-gray-600">
                            {{ $secret }}
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-7 h-7 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center text-xs font-bold text-indigo-700 dark:text-indigo-300">2</span>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Verify Code</h3>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Enter the 6-digit code from your authenticator app to confirm setup.
                        </p>

                        @error('code')
                            <div class="mb-3 p-3 text-sm text-red-700 bg-red-50 dark:bg-red-900/30 dark:text-red-300 rounded-lg">
                                {{ $message }}
                            </div>
                        @enderror

                        <form method="POST" action="{{ route('customer.profile.two-factor.confirm') }}">
                            @csrf
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                <input type="text" name="code" maxlength="6" inputmode="numeric"
                                    class="flex-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-center text-lg font-mono font-bold tracking-[0.3em] placeholder-gray-400"
                                    placeholder="000000" autofocus required>
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-md transition">
                                    Confirm
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Cancel --}}
                    <div class="text-center pt-2">
                        <a href="{{ route('customer.profile') }}"
                           class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            &larr; Cancel and go back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
