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

        $oldEmail = $user->email;

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

        // If the email address changed, clear verification timestamp
        if ($validated['email'] !== $oldEmail) {
            $user->email_verified_at = null;
            $user->save();
        }

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Show login activity and suspicious activity tracking.
     */
    public function loginActivity()
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'CUSTOMER') {
            abort(403, 'Unauthorized');
        }

        $loginLogs = $user->loginLogs()
            ->orderByDesc('created_at')
            ->paginate(20);

        // Stats
        $totalLogins = $user->loginLogs()->count();
        $suspiciousCount = $user->loginLogs()->where('is_suspicious', true)->count();
        $uniqueIps = $user->loginLogs()->distinct('ip_address')->count('ip_address');
        $lastLogin = $user->loginLogs()->orderByDesc('created_at')->first();

        return view('customer.profile.login-activity', [
            'user' => $user,
            'loginLogs' => $loginLogs,
            'totalLogins' => $totalLogins,
            'suspiciousCount' => $suspiciousCount,
            'uniqueIps' => $uniqueIps,
            'lastLogin' => $lastLogin,
        ]);
    }

    /**
     * Update security questions.
     */
    public function updateSecurityQuestions(Request $request)
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'CUSTOMER') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'security_question_1' => ['required', 'string', 'max:255'],
            'security_answer_1'   => ['required', 'string', 'max:255'],
            'security_question_2' => ['required', 'string', 'max:255'],
            'security_answer_2'   => ['required', 'string', 'max:255'],
            'security_question_3' => ['required', 'string', 'max:255'],
            'security_answer_3'   => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Security questions updated successfully.');
    }

    /**
     * Delete the logged-in customer's account after password confirmation.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        if (! $user || strtoupper($user->role) !== 'CUSTOMER') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'The provided password is incorrect.'], 'userDeletion');
        }

        Auth::logout();

        $user->delete();

        return redirect('/');
    }
}
