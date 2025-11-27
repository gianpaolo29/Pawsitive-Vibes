<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the logged-in customer's profile page.
     */
    public function index()
    {
        $user = Auth::user();

        // just to be safe: only allow CUSTOMER role here
        if (! $user || strtoupper($user->role) !== 'CUSTOMER') {
            abort(403, 'Unauthorized');
        }

        return view('customer.profile.show', [
            'user' => $user,
        ]);
    }

    /**
     * Update the logged-in customer's profile.
     *
     * (Optional) Create this route:
     * Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'CUSTOMER') {
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
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $updateData = [
            'fname'    => $validated['fname'],
            'lname'    => $validated['lname'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Profile updated successfully.');
    }
}
