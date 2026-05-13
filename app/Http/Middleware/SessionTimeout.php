<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    /**
     * Session timeout in minutes.
     */
    const TIMEOUT_MINUTES = 15;

    /**
     * Warning shown before timeout (in minutes).
     * The JS countdown will start this many minutes before auto-logout.
     */
    const WARNING_MINUTES = 2;

    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $lastActivity = session('last_activity_time');

        if ($lastActivity && (time() - $lastActivity) > (self::TIMEOUT_MINUTES * 60)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'session_expired',
            ]);
        }

        session(['last_activity_time' => time()]);

        return $next($request);
    }
}
