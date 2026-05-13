<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerTwoFactor
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (
            $user
            && strtoupper($user->role) === 'CUSTOMER'
            && $user->two_factor_confirmed_at
            && ! session('customer_2fa_verified')
        ) {
            return redirect()->route('customer.two-factor.challenge');
        }

        return $next($request);
    }
}
