<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AdminProfileController extends Controller
{
    /**
     * Show Admin Profile page.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        // Optional: keep if you want to be extra sure it's admin
        if (! $user || strtoupper($user->role) !== 'ADMIN') {
            abort(403, 'Unauthorized');
        }

        return view('admin.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update basic profile info (fname, lname, username, email).
     * route: admin.profile.update (PATCH)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'ADMIN') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update([
            'fname'    => $validated['fname'],
            'lname'    => $validated['lname'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
        ]);

        // your Blade checks: session('status') === 'profile-updated'
        return back()->with('status', 'profile-updated');
    }

    /**
     * Update admin password.
     * route: admin.password.update (PUT)
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'ADMIN') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',          // matches password_confirmation
                PasswordRule::min(8), // or PasswordRule::defaults()
            ],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // your Blade checks: session('status') === 'password-updated'
        return back()->with('status', 'password-updated');
    }
}
