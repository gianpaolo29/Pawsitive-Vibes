<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'username'   => ['required','string','max:50','unique:users,username'],
            'email'      => ['required','string','lowercase','email','max:255','unique:users,email'],
            'password'   => ['required','confirmed', Rules\Password::defaults()],
        ]);

        $user = \App\Models\User::create([
            'fname'    => $data['first_name'],
            'lname'    => $data['last_name'],
            'username' => $data['username'],
            'name'     => trim($data['first_name'].' '.$data['last_name']),
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => 'CUSTOMER', 
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('customer.home', absolute: false));
    }
}
