<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

uses(TestCase::class);

it('detects the third failed login attempt', function () {
    Cache::flush();

    $this->withoutMiddleware(\Illuminate\Auth\Middleware\RedirectIfAuthenticated::class);

    Auth::shouldReceive('attempt')->times(3)->andReturn(false);

    $this->post(route('login'), [
        'email' => 'user@example.com',
        'password' => 'wrong-pass',
    ])->assertSessionHasErrors(['email' => 'failed:2']);

    $this->post(route('login'), [
        'email' => 'user@example.com',
        'password' => 'wrong-pass',
    ])->assertSessionHasErrors(['email' => 'failed:1']);

    $this->post(route('login'), [
        'email' => 'user@example.com',
        'password' => 'wrong-pass',
    ])->assertSessionHasErrors(['email' => 'locked:5']);
});

it('sends password reset link request', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => 'user@example.com'])
        ->andReturn(Password::RESET_LINK_SENT);

    $this->post(route('password.email'), [
        'email' => 'user@example.com',
    ])->assertSessionHas('status');
});

it('validates forgot password email input', function () {
    $this->post(route('password.email'), [
        'email' => 'invalid-email',
    ])->assertSessionHasErrors(['email']);
});

it('validates reset password required fields', function () {
    $this->post(route('password.store'), [])->assertSessionHasErrors([
        'token',
        'email',
        'password',
    ]);
});

it('rejects reset request when token is invalid', function () {
    Password::shouldReceive('reset')
        ->once()
        ->andReturn(Password::INVALID_TOKEN);

    $this->post(route('password.store'), [
        'token' => 'bad-token',
        'email' => 'user@example.com',
        'password' => 'Newpass123!',
        'password_confirmation' => 'Newpass123!',
    ])->assertSessionHasErrors(['email']);
});
