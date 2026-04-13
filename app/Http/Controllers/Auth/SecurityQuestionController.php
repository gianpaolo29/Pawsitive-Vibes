<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class SecurityQuestionController extends Controller
{
    /**
     * Show form to select which recovery method after 3 failed logins.
     */
    public function showRecoveryOptions(Request $request)
    {
        $email = $request->query('email', old('email'));

        return view('auth.recovery-options', compact('email'));
    }

    /**
     * Show the security question verification form.
     */
    public function showQuestions(Request $request)
    {
        $email = $request->query('email', old('email'));
        $user = User::where('email', $email)->first();

        if (! $user || ! $user->security_question_1) {
            return redirect()->route('password.request')
                ->with('status', 'No security questions found for this account. Please use the email reset option.');
        }

        return view('auth.security-questions', [
            'email' => $email,
            'question1' => $user->security_question_1,
            'question2' => $user->security_question_2,
            'question3' => $user->security_question_3,
        ]);
    }

    /**
     * Verify security question answers and show password reset form.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'answer_1' => ['required', 'string'],
            'answer_2' => ['required', 'string'],
            'answer_3' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! $user->security_question_1) {
            return back()->withErrors(['email' => 'Account not found.'])->withInput();
        }

        $correct = strtolower(trim($request->answer_1)) === strtolower(trim($user->security_answer_1))
            && strtolower(trim($request->answer_2)) === strtolower(trim($user->security_answer_2))
            && strtolower(trim($request->answer_3)) === strtolower(trim($user->security_answer_3));

        if (! $correct) {
            return back()->withErrors(['answers' => 'One or more answers are incorrect. Please try again.'])->withInput();
        }

        // Generate a temporary token and store in session
        $token = Str::random(60);
        session(['security_reset_token' => $token, 'security_reset_email' => $request->email]);

        return redirect()->route('security.reset-password', ['token' => $token]);
    }

    /**
     * Show password reset form after security question verification.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->route('token');

        if ($token !== session('security_reset_token')) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid or expired security reset session.']);
        }

        return view('auth.security-reset-password', [
            'token' => $token,
            'email' => session('security_reset_email'),
        ]);
    }

    /**
     * Reset password after security question verification.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        if ($request->token !== session('security_reset_token')) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid or expired security reset session.']);
        }

        $email = session('security_reset_email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('login')->withErrors(['email' => 'Account not found.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // Clear session data and login attempt counters
        session()->forget(['security_reset_token', 'security_reset_email']);
        cache()->forget('login-count:' . $request->ip() . '|' . $email);
        cache()->forget('login-locked:' . $request->ip() . '|' . $email);

        return redirect()->route('login')->with('status', 'Your password has been reset successfully! Please log in.');
    }
}
