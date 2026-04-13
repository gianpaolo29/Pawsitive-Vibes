<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginSecurityService;
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

        $user = $request->user();

        // Check if time-based block has expired
        if (!$user->is_active && $user->blocked_until && $user->blocked_until->isPast()) {
            $user->update([
                'is_active' => true,
                'blocked_reason' => null,
                'blocked_until' => null,
            ]);
        }

        // Check if account is deactivated
        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $reason = $user->blocked_reason ?? '';
            if (str_contains($reason, 'Suspicious')) {
                return back()->withErrors(['email' => 'blocked_suspicious'])->onlyInput('email');
            }
            return back()->withErrors(['email' => 'deactivated'])->onlyInput('email');
        }

        // Log the login and check for suspicious activity
        $securityCheck = LoginSecurityService::logAndCheck($user, $request);

        if ($securityCheck['blocked']) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors(['email' => 'blocked_suspicious'])->onlyInput('email');
        }

        // Success — clear everything
        cache()->forget($attemptKey);
        cache()->forget($lockKey);
        $request->session()->regenerate();

        session()->flash('welcome_user', $user->fname ?? $user->username);

        // Admin always goes to dashboard, never follow intended URL
        if ($user->role === 'ADMIN') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('welcome'));
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
