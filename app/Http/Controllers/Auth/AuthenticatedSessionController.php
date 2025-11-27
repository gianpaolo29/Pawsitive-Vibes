<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            return back()->withErrors([
                'username' => 'These credentials do not match our records.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();


        
        $user = $request->user();

        
        return redirect()->intended($user->role === 'ADMIN' ? route('admin.dashboard') : route('customer.home'));
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
