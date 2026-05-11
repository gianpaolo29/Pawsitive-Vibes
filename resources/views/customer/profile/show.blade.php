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
                            {{-- Profile (Active Link) --}}
                            <a href="{{ route('customer.profile') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                               {{ $current === 'customer.profile' ? 'bg-indigo-600 text-white shadow-md font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A10.97 10.97 0 0112 15c2.21 0 4.267.64 5.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Profile</span>
                            </a>

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

                            {{-- Login Activity --}}
                            <a href="{{ route('customer.profile.login-activity') }}"
                               class="flex items-center gap-2 px-3 py-2 rounded-lg transition duration-150
                               {{ $current === 'customer.profile.login-activity' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200 font-semibold' : 'text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                <span>Login Activity</span>
                            </a>

                            {{-- Logout Link --}}
                            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="w-full pt-2">
                                @csrf
                                <button type="button" onclick="confirmLogout()" class="flex items-center gap-2 px-3 py-2 w-full text-left rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/40 transition duration-150 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </nav>
                    </div>
                </aside>

                {{-- MAIN CONTENT (PROFILE FORM) --}}
                <section class="md:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 md:p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 border-b pb-3">
                            Account Details
                        </h2>


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

                    {{-- TWO-FACTOR AUTHENTICATION --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 md:p-6 mt-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 border-b pb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Two-Factor Authentication
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 mb-5">
                            Add an extra layer of security using Google Authenticator. When enabled, you'll need to enter a code from your authenticator app each time you log in.
                        </p>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-4 rounded-xl {{ $user->two_factor_confirmed_at ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800' : 'bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600' }}">
                            <div class="flex items-center gap-3">
                                @if($user->two_factor_confirmed_at)
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">2FA is Enabled</p>
                                        <p class="text-xs text-emerald-600/70 dark:text-emerald-500/70">Protected with Google Authenticator.</p>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">2FA is Disabled</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Enable it for extra security on your account.</p>
                                    </div>
                                @endif
                            </div>

                            @if($user->two_factor_confirmed_at)
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                                    <a href="{{ route('customer.profile.two-factor.recovery-codes') }}"
                                       class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                        Recovery Codes
                                    </a>
                                    <form id="disable2faForm" method="POST" action="{{ route('customer.profile.two-factor.disable') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="code" id="disable2faCode">
                                        <button type="button"
                                            onclick="confirmDisable2FA()"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-semibold bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 transition">
                                            Disable 2FA
                                        </button>
                                    </form>
                                </div>
                            @else
                                <a href="{{ route('customer.profile.two-factor.setup') }}"
                                   class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-600 text-white hover:bg-indigo-700 shadow-md transition">
                                    Enable 2FA
                                </a>
                            @endif
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash messages
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    confirmButtonColor: '#6366f1',
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: @json(session('error')),
                    confirmButtonColor: '#6366f1',
                });
            @endif

            // Show recovery codes in SweetAlert after enabling 2FA
            @if(session('recovery_codes'))
                const codes = @json(session('recovery_codes'));
                const codesHtml = codes.map(c => `<code style="display:inline-block;background:#f3f4f6;padding:6px 14px;border-radius:8px;font-family:monospace;font-weight:700;font-size:14px;margin:4px;border:1px solid #e5e7eb;">${c}</code>`).join('');

                Swal.fire({
                    html: `
                        <div style="text-align:center;padding:5px 0;">
                            <div style="font-size:40px;margin-bottom:10px;">🔑</div>
                            <h2 style="font-size:20px;font-weight:700;color:#1f2937;margin-bottom:8px;">Save Your Recovery Codes</h2>
                            <p style="color:#6b7280;font-size:13px;margin-bottom:16px;">Store these codes somewhere safe. Each code can only be used <strong>once</strong> if you lose access to your authenticator app.</p>
                            <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:4px;margin-bottom:12px;">
                                ${codesHtml}
                            </div>
                            <p style="color:#92400e;font-size:12px;background:#fffbeb;padding:10px;border-radius:8px;border:1px solid #fde68a;margin-top:12px;">
                                ⚠️ These codes will <strong>not</strong> be shown again. Save them now!
                            </p>
                        </div>
                    `,
                    confirmButtonText: 'I\'ve Saved Them',
                    confirmButtonColor: '#6366f1',
                    width: 480,
                    allowOutsideClick: false,
                });
            @endif
        });

        // Disable 2FA confirmation
        function confirmDisable2FA() {
            Swal.fire({
                html: `
                    <div style="text-align:center;padding:5px 0;">
                        <div style="font-size:40px;margin-bottom:10px;">🔐</div>
                        <h2 style="font-size:18px;font-weight:700;color:#1f2937;margin-bottom:6px;">Verify to Disable 2FA</h2>
                        <p style="color:#6b7280;font-size:13px;margin-bottom:16px;">Enter the 6-digit code from your <strong>Google Authenticator</strong> app to confirm.</p>
                    </div>
                `,
                input: 'text',
                inputAttributes: {
                    maxlength: 6,
                    inputmode: 'numeric',
                    pattern: '[0-9]*',
                    autocomplete: 'one-time-code',
                    style: 'text-align:center;font-size:24px;font-weight:700;letter-spacing:8px;font-family:monospace;border:2px solid #e5e7eb;border-radius:12px;padding:12px;',
                    placeholder: '000000',
                },
                showCancelButton: true,
                confirmButtonText: 'Disable 2FA',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                preConfirm: (code) => {
                    if (!code || code.length !== 6 || !/^\d{6}$/.test(code)) {
                        Swal.showValidationMessage('Please enter a valid 6-digit code');
                        return false;
                    }
                    return code;
                },
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    document.getElementById('disable2faCode').value = result.value;
                    document.getElementById('disable2faForm').submit();
                }
            });
        }

        function confirmLogout() {
            Swal.fire({
                icon: 'question',
                title: 'Log Out',
                text: 'Do you want to log out of your account?',
                showCancelButton: true,
                confirmButtonText: 'Yes, Log Out',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>
</x-app-layout>
