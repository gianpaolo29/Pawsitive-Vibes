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

        $throttleKey = 'login:' . $request->ip() . '|' . $credentials['email'];
        $lockKey     = 'login-locked:' . $request->ip() . '|' . $credentials['email'];
        $attemptKey  = 'login-count:' . $request->ip() . '|' . $credentials['email'];

        // Check if permanently locked (3 failed attempts)
        $totalAttempts = (int) cache()->get($attemptKey, 0);
        if ($totalAttempts >= 3) {
            return redirect()->route('recovery.options', ['email' => $credentials['email']]);
        }

        // Check if in a delay period
        if (cache()->has($lockKey)) {
            $seconds = cache()->get($lockKey) - now()->timestamp;
            if ($seconds > 0) {
                if ($seconds > 60) {
                    return back()->withErrors(['email' => 'delay_minutes:' . ceil($seconds / 60)])->onlyInput('email');
                }
                return back()->withErrors(['email' => 'delay_seconds:' . $seconds])->onlyInput('email');
            }
            cache()->forget($lockKey);
        }

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $totalAttempts++;
            cache()->put($attemptKey, $totalAttempts, now()->addMinutes(30));

            if ($totalAttempts === 1) {
                // 1st fail → 10 second delay
                cache()->put($lockKey, now()->addSeconds(10)->timestamp, now()->addSeconds(10));
                return back()->withErrors(['email' => 'attempt_1'])->onlyInput('email');
            } elseif ($totalAttempts === 2) {
                // 2nd fail → 5 minute delay
                cache()->put($lockKey, now()->addMinutes(5)->timestamp, now()->addMinutes(5));
                return back()->withErrors(['email' => 'attempt_2'])->onlyInput('email');
            } else {
                // 3rd fail → redirect to recovery
                return redirect()->route('recovery.options', ['email' => $credentials['email']]);
            }
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
