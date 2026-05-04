<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (
            $user
            && strtoupper($user->role) === 'ADMIN'
            && $user->two_factor_confirmed_at
            && ! session('admin_2fa_verified')
        ) {
            return redirect()->route('admin.two-factor.challenge');
        }

        return $next($request);
    }
}
