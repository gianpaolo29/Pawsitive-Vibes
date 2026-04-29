<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class AdminTwoFactorController extends Controller
{
    /**
     * Show the 2FA challenge page (enter 6-digit code).
     */
    public function challenge(Request $request)
    {
        $user = $request->user();

        if (! $user || strtoupper($user->role) !== 'ADMIN' || ! $user->two_factor_confirmed_at) {
            return redirect()->route('admin.dashboard');
        }

        if (session('admin_2fa_verified')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.two-factor-challenge');
    }

    /**
     * Verify the 2FA code.
     */
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $user = $request->user();
        $google2fa = app(Google2FA::class);
        $secret = decrypt($user->two_factor_secret);

        // Try TOTP code first
        if ($google2fa->verifyKey($secret, $request->code)) {
            session(['admin_2fa_verified' => true]);
            return redirect()->route('admin.dashboard');
        }

        // Try recovery code
        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true) ?? [];
        if (in_array($request->code, $recoveryCodes, true)) {
            // Remove used recovery code
            $remaining = array_values(array_diff($recoveryCodes, [$request->code]));
            $user->forceFill([
                'two_factor_recovery_codes' => encrypt(json_encode($remaining)),
            ])->save();

            session(['admin_2fa_verified' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['code' => 'invalid']);
    }

    /**
     * Show 2FA setup page with QR code.
     */
    public function setup(Request $request)
    {
        $user = $request->user();

        if (! $user->two_factor_secret) {
            $google2fa = app(Google2FA::class);
            $user->forceFill([
                'two_factor_secret' => encrypt($google2fa->generateSecretKey()),
            ])->save();
        }

        return view('admin.auth.two-factor-setup', [
            'qrSvg' => $user->twoFactorQrCodeSvg(),
            'secret' => decrypt($user->two_factor_secret),
        ]);
    }

    /**
     * Confirm 2FA setup by verifying a code from the authenticator app.
     */
    public function confirmSetup(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $user = $request->user();
        $google2fa = app(Google2FA::class);
        $secret = decrypt($user->two_factor_secret);

        if (! $google2fa->verifyKey($secret, $request->code)) {
            return back()->withErrors(['code' => 'The code is incorrect. Make sure your authenticator app is synced.']);
        }

        $user->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => encrypt(json_encode(
                collect(range(1, 8))->map(fn () => Str::random(10))->all()
            )),
        ])->save();

        session(['admin_2fa_verified' => true]);

        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        return redirect()->route('admin.profile')
            ->with('success', 'Two-factor authentication enabled!')
            ->with('recovery_codes', $recoveryCodes);
    }

    /**
     * Disable 2FA.
     */
    public function disable(Request $request)
    {
        $request->validate(['code' => 'required|string|size:6']);

        $user = $request->user();
        $google2fa = app(Google2FA::class);
        $secret = decrypt($user->two_factor_secret);

        if (! $google2fa->verifyKey($secret, $request->code)) {
            return back()->with('error', 'Invalid code. Please enter the correct code from your authenticator app.');
        }

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        session()->forget('admin_2fa_verified');

        return redirect()->route('admin.profile')
            ->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Show recovery codes.
     */
    public function recoveryCodes(Request $request)
    {
        $user = $request->user();

        if (! $user->two_factor_confirmed_at) {
            return redirect()->route('admin.profile');
        }

        $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        return view('admin.auth.two-factor-recovery', ['codes' => $codes]);
    }
}
