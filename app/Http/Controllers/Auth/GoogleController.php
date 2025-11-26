<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        // No semicolon before chaining; call redirect ONCE.
        // (You can omit stateless() here; we'll use it in callback.)
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            // Use stateless() here to avoid state mismatch in local setups
            $g = Socialite::driver('google')->stateless()->user();

            // 1) Find by google_id
            $user = User::where('google_id', $g->getId())->first();

            // 2) If not found, try by email and link
            if (!$user && $g->getEmail()) {
                $user = User::where('email', $g->getEmail())->first();
                if ($user) {
                    $user->google_id = $g->getId();
                    $user->avatar    = $g->getAvatar();
                    $user->save();
                }
            }

            // 3) Or create new
            if (!$user) {
                $user = User::create([
                    'name'              => $g->getName() ?: 'Google User',
                    'email'             => $g->getEmail(), // allow nullable if Google hides email
                    'google_id'         => $g->getId(),
                    'avatar'            => $g->getAvatar(),
                    'password'          => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'role'              => 'customer',
                ]);
            }

            Auth::guard('web')->login($user, remember: true);

            return redirect()->intended(route('dashboard'));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')->withErrors([
                'google' => 'Google sign-in failed. Please try again.',
            ]);
        }
    }
}
