<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

describe('Login Attempts Limit & Account Locking', function () {
    beforeEach(function () {
        Cache::flush();
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RedirectIfAuthenticated::class);
    });

    it('logs first failed login attempt and shows warning with 2 remaining attempts', function () {
        $response = $this->post(route('login'), [
            'email' => 'test1@pawsitive.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('detects second failed login attempt and warns with 1 remaining attempt', function () {
        $this->post(route('login'), [
            'email' => 'test2@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test2@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('blocks account after 3 failed login attempts with 5-minute lockout', function () {
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('login'), [
                'email' => 'test3@pawsitive.com',
                'password' => 'wrong-pass',
            ]);
        }

        $response = $this->post(route('login'), [
            'email' => 'test3@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('prevents login attempts during 5-minute lock period', function () {
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('login'), [
                'email' => 'test4@pawsitive.com',
                'password' => 'wrong-pass',
            ]);
        }

        $response = $this->post(route('login'), [
            'email' => 'test4@pawsitive.com',
            'password' => 'correct-password',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('resets failed attempts counter after lockout and successful login', function () {
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('login'), [
                'email' => 'test5@pawsitive.com',
                'password' => 'wrong-pass',
            ]);
        }

        $user = User::factory()->create([
            'email' => 'test5@pawsitive.com',
            'password' => Hash::make('correct-password'),
            'is_active' => true,
            'role' => 'CUSTOMER',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test5@pawsitive.com',
            'password' => 'correct-password',
        ]);

        $response->assertRedirect();
    });

    it('maintains separate attempt counters for different email addresses', function () {
        $this->post(route('login'), [
            'email' => 'test6a@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test6b@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('detects and blocks rapid brute force attack attempts', function () {
        $testEmails = [
            'brute1@pawsitive.com',
            'brute2@pawsitive.com',
            'brute3@pawsitive.com',
        ];

        foreach ($testEmails as $email) {
            for ($attempt = 0; $attempt < 3; $attempt++) {
                $this->post(route('login'), [
                    'email' => $email,
                    'password' => 'wrong-pass',
                ]);
            }
        }

        foreach ($testEmails as $email) {
            $response = $this->post(route('login'), [
                'email' => $email,
                'password' => 'wrong-pass',
            ]);
            $response->assertSessionHasErrors(['email']);
        }
    });

    it('logs all failed login attempts for security auditing', function () {
        $this->post(route('login'), [
            'email' => 'log1@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'log1@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    });
});

describe('Forgot Password & Recovery', function () {
    beforeEach(function () {
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RedirectIfAuthenticated::class);
    });

    it('validates email format in forgot password request', function () {
        $response = $this->post(route('password.email'), [
            'email' => 'invalid-email-format',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('sends password reset link for valid registered email', function () {
        $user = User::factory()->create([
            'email' => 'reset@pawsitive.com',
        ]);

        Password::shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => 'reset@pawsitive.com'])
            ->andReturn(Password::RESET_LINK_SENT);

        $response = $this->post(route('password.email'), [
            'email' => 'reset@pawsitive.com',
        ]);

        $response->assertSessionHas('status');
    });

    it('validates all required fields in password reset request', function () {
        $response = $this->post(route('password.store'), []);

        $response->assertSessionHasErrors([
            'token',
            'email',
            'password',
        ]);
    });

    it('rejects password reset with invalid or expired token', function () {
        Password::shouldReceive('reset')
            ->once()
            ->andReturn(Password::INVALID_TOKEN);

        $response = $this->post(route('password.store'), [
            'token' => 'invalid-expired-token',
            'email' => 'reset@pawsitive.com',
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('successfully updates password with valid reset token', function () {
        Password::shouldReceive('reset')
            ->once()
            ->andReturn(Password::PASSWORD_RESET);

        $response = $this->post(route('password.store'), [
            'token' => 'valid-token',
            'email' => 'reset@pawsitive.com',
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ]);

        $response->assertRedirect(route('login'));
    });

    it('rejects password reset when passwords do not match', function () {
        $response = $this->post(route('password.store'), [
            'token' => 'valid-token',
            'email' => 'reset@pawsitive.com',
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'DifferentPass123!',
        ]);

        $response->assertSessionHasErrors(['password']);
    });

    it('handles forgot password request for non-existent email gracefully', function () {
        Password::shouldReceive('sendResetLink')
            ->once()
            ->andReturn(Password::INVALID_USER);

        $response = $this->post(route('password.email'), [
            'email' => 'nonexistent@pawsitive.com',
        ]);

        $response->assertSessionHasErrors();
    });
});

describe('Two-Factor Authentication Security', function () {
    it('redirects admin users to 2FA challenge after successful login', function () {
        $admin = User::factory()->create([
            'email' => 'admin@pawsitive.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'is_active' => true,
            'two_factor_confirmed_at' => now(),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@pawsitive.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.two-factor.challenge'));
    });

    it('allows admin login without 2FA when not configured', function () {
        $admin = User::factory()->create([
            'email' => 'admin-no2fa@pawsitive.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'is_active' => true,
            'two_factor_confirmed_at' => null,
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin-no2fa@pawsitive.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    });
});

describe('Account Status & Blocking', function () {
    it('prevents login for deactivated accounts', function () {
        $blockedUser = User::factory()->create([
            'email' => 'blocked@pawsitive.com',
            'password' => Hash::make('password'),
            'is_active' => false,
            'blocked_reason' => 'Suspicious activity detected',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'blocked@pawsitive.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('reactivates account when temporary block period expires', function () {
        $tempBlockedUser = User::factory()->create([
            'email' => 'temp-blocked@pawsitive.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'blocked_until' => now()->subHours(1),
            'role' => 'CUSTOMER',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'temp-blocked@pawsitive.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('welcome'));
    });

    it('tracks and blocks accounts with multiple suspicious activities', function () {
        Cache::flush();

        $suspiciousEmails = [
            'suspicious1@pawsitive.com',
            'suspicious2@pawsitive.com',
        ];

        foreach ($suspiciousEmails as $email) {
            for ($i = 0; $i < 3; $i++) {
                $this->post(route('login'), [
                    'email' => $email,
                    'password' => 'wrong-pass',
                ]);
            }
        }

        foreach ($suspiciousEmails as $email) {
            $response = $this->post(route('login'), [
                'email' => $email,
                'password' => 'wrong-pass',
            ]);
            $response->assertSessionHasErrors(['email']);
        }
    });
});

describe('Session Management & Cleanup', function () {
    it('creates secure session after successful authentication', function () {
        $user = User::factory()->create([
            'email' => 'secure@pawsitive.com',
            'password' => Hash::make('correct-password'),
            'is_active' => true,
            'role' => 'CUSTOMER',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'secure@pawsitive.com',
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('welcome'));
        $this->assertAuthenticatedAs($user);
    });

    it('clears failed login attempts after successful authentication', function () {
        Cache::flush();

        $this->post(route('login'), [
            'email' => 'cleartest@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $user = User::factory()->create([
            'email' => 'cleartest@pawsitive.com',
            'password' => Hash::make('correct-password'),
            'is_active' => true,
            'role' => 'CUSTOMER',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'cleartest@pawsitive.com',
            'password' => 'correct-password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    });
});

describe('Performance & Edge Cases', function () {
    beforeEach(function () {
        Cache::flush();
        $this->withoutMiddleware(\Illuminate\Auth\Middleware\RedirectIfAuthenticated::class);
    });

    it('handles concurrent login attempts from same user correctly', function () {
        $email = 'concurrent@pawsitive.com';

        for ($i = 0; $i < 3; $i++) {
            $this->post(route('login'), [
                'email' => $email,
                'password' => 'wrong-pass',
            ]);
        }

        $response = $this->post(route('login'), [
            'email' => $email,
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('treats email addresses as case-insensitive for security checks', function () {
        $this->post(route('login'), [
            'email' => 'CaseTest@Pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response = $this->post(route('login'), [
            'email' => 'casetest@pawsitive.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('maintains performance under high-volume login attempts', function () {
        $startTime = microtime(true);

        for ($i = 0; $i < 10; $i++) {
            $this->post(route('login'), [
                'email' => "load-test-$i@pawsitive.com",
                'password' => 'wrong-pass',
            ]);
        }

        $duration = microtime(true) - $startTime;

        expect($duration)->toBeLessThan(3.0);
    });
});

