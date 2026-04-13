<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','string','email'],
            'password' => ['required','string'],
        ]);

        $attemptKey = 'login-count:' . $request->ip() . '|' . $credentials['email'];
        $lockKey    = 'login-locked:' . $request->ip() . '|' . $credentials['email'];

        // Check if locked (5 minute cooldown after 3 fails)
        if (cache()->has($lockKey)) {
            $seconds = (int) cache()->get($lockKey) - now()->timestamp;
            if ($seconds > 0) {
                $minutes = ceil($seconds / 60);
                return back()->withErrors(['email' => 'locked:' . $minutes])->onlyInput('email');
            }
            // Lock expired — reset everything
            cache()->forget($lockKey);
            cache()->forget($attemptKey);
        }

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $totalAttempts = (int) cache()->get($attemptKey, 0) + 1;
            cache()->put($attemptKey, $totalAttempts, now()->addMinutes(10));

            $remaining = 3 - $totalAttempts;

            if ($totalAttempts >= 3) {
                // Lock for 5 minutes
                cache()->put($lockKey, now()->addMinutes(5)->timestamp, now()->addMinutes(5));
                cache()->put($attemptKey, $totalAttempts, now()->addMinutes(5));
                return back()->withErrors(['email' => 'locked:5'])->onlyInput('email');
            }

            return back()->withErrors(['email' => 'failed:' . $remaining])->onlyInput('email');
        }

        // Success — clear everything
        cache()->forget($attemptKey);
        cache()->forget($lockKey);
        $request->session()->regenerate();

        $user = $request->user();

        return redirect()->intended($user->role === 'ADMIN' ? route('admin.dashboard') : route('welcome'));
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
