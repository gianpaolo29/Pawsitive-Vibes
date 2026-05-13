<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LoginSecurityService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $g = Socialite::driver('google')->stateless()->user();

            // Find by email
            $user = $g->getEmail() ? User::where('email', $g->getEmail())->first() : null;

            // Or create new
            if (!$user) {
                [$fname, $lname] = $this->splitName($g->getName());

                $user = User::create([
                    'fname'             => $fname,
                    'lname'             => $lname,
                    'username'          => $this->uniqueUsername($g->getEmail(), $fname, $lname),
                    'email'             => $g->getEmail(),
                    'password'          => bcrypt(Str::random(32)),
                    'email_verified_at' => now(),
                    'role'              => 'CUSTOMER',
                ]);
            }

            Auth::guard('web')->login($user, true);

            // Log the login and check for suspicious activity
            $securityCheck = LoginSecurityService::logAndCheck($user, request());

            if ($securityCheck['blocked']) {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect()->route('login')->withErrors([
                    'email' => 'blocked_suspicious',
                ]);
            }

            session()->flash('welcome_user', $user->fname ?? $user->username);

            if ($user->role === 'ADMIN') {
                if ($user->two_factor_confirmed_at) {
                    return redirect()->route('admin.two-factor.challenge');
                }
                return redirect()->route('admin.dashboard');
            }

            // Customer: check if 2FA is enabled
            if ($user->two_factor_confirmed_at) {
                return redirect()->route('customer.two-factor.challenge');
            }

            return redirect()->intended(route('welcome'));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')->withErrors([
                'email' => 'Google sign-in failed. Please try again.',
            ]);
        }
    }

    private function splitName(?string $full): array
    {
        $full = trim((string) $full);
        if ($full === '') {
            return ['Google', 'User'];
        }
        $parts = preg_split('/\s+/', $full, 2);
        return [$parts[0] ?? 'Google', $parts[1] ?? 'User'];
    }

    private function uniqueUsername(?string $email, string $fname, string $lname): string
    {
        if ($email && str_contains($email, '@')) {
            $base = explode('@', $email)[0];
        } else {
            $base = strtolower(preg_replace('/[^a-z0-9]+/i', '', $fname . $lname)) ?: 'user';
        }
        $base = mb_substr($base, 0, 90);

        $candidate = $base;
        $i = 1;
        while (DB::table('users')->where('username', $candidate)->exists()) {
            $candidate = $base . $i++;
        }
        return $candidate;
    }
}
