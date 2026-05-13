<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    /**
     * Show the 2FA challenge page for customers.
     */
    public function challenge(Request $request)
    {
        $user = $request->user();

        if (! $user || ! $user->two_factor_confirmed_at) {
            return redirect()->route('welcome');
        }

        if (session('customer_2fa_verified')) {
            return redirect()->route('welcome');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the 2FA code for customers.
     */
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $user = $request->user();
        $google2fa = app(Google2FA::class);
        $secret = decrypt($user->two_factor_secret);

        // Try TOTP code first
        if ($google2fa->verifyKey($secret, $request->code)) {
            session(['customer_2fa_verified' => true]);
            return redirect()->intended(route('welcome'));
        }

        // Try recovery code
        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true) ?? [];
        if (in_array($request->code, $recoveryCodes, true)) {
            $remaining = array_values(array_diff($recoveryCodes, [$request->code]));
            $user->forceFill([
                'two_factor_recovery_codes' => encrypt(json_encode($remaining)),
            ])->save();

            session(['customer_2fa_verified' => true]);
            return redirect()->intended(route('welcome'));
        }

        return back()->withErrors(['code' => 'invalid']);
    }

    /**
     * Show 2FA setup page with QR code.
     */
    public function setup(Request $request)
    {
        $user = $request->user();

        // Enable 2FA (generates secret)
        if (!$user->two_factor_secret) {
            $user->forceFill([
                'two_factor_secret' => encrypt(app(\Laravel\Fortify\Actions\GenerateNewRecoveryCodes::class)
                    ? app(\PragmaRX\Google2FA\Google2FA::class)->generateSecretKey()
                    : null),
            ])->save();
        }

        return view('auth.two-factor-setup', [
            'qrSvg' => $user->twoFactorQrCodeSvg(),
            'secret' => decrypt($user->two_factor_secret),
        ]);
    }

    /**
     * Confirm 2FA by verifying a code from the app.
     */
    public function confirmSetup(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $user = $request->user();
        $google2fa = app(\PragmaRX\Google2FA\Google2FA::class);
        $secret = decrypt($user->two_factor_secret);

        if (!$google2fa->verifyKey($secret, $request->code)) {
            return back()->withErrors(['code' => 'The code is incorrect. Make sure your authenticator app is synced.']);
        }

        $user->forceFill([
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => encrypt(json_encode(
                collect(range(1, 8))->map(fn () => \Illuminate\Support\Str::random(10))->all()
            )),
        ])->save();

        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        return redirect()->route('customer.profile')
            ->with('success', 'Two-factor authentication enabled!')
            ->with('recovery_codes', $recoveryCodes);
    }

    /**
     * Disable 2FA (requires OTP verification).
     */
    public function disable(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();
        $google2fa = app(\PragmaRX\Google2FA\Google2FA::class);
        $secret = decrypt($user->two_factor_secret);

        if (!$google2fa->verifyKey($secret, $request->code)) {
            return back()->with('error', 'Invalid code. Please enter the correct code from your authenticator app.');
        }

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return redirect()->route('customer.profile')
            ->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Show recovery codes.
     */
    public function recoveryCodes(Request $request)
    {
        $user = $request->user();

        if (!$user->two_factor_confirmed_at) {
            return redirect()->route('customer.profile');
        }

        $codes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        return view('auth.two-factor-recovery', ['codes' => $codes]);
    }
}
