<?php

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

function makeAuthUser(array $overrides = []): User
{
    return User::create(array_merge([
        'fname' => 'Test',
        'lname' => 'User',
        'username' => 'tester'.str()->random(8),
        'email' => 'user'.str()->random(6).'@example.com',
        'password' => Hash::make('password123'),
        'role' => 'CUSTOMER',
        'is_active' => true,
    ], $overrides));
}

it('detects third failed attempt and blocks login', function () {
    $user = makeAuthUser();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors(['email']);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors(['email']);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors(['email']);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password123',
    ])->assertSessionHasErrors(['email']);

    $this->assertGuest();
});

it('sends password reset link to existing user email', function () {
    Notification::fake();

    $user = makeAuthUser();

    $this->post(route('password.email'), [
        'email' => $user->email,
    ])->assertSessionHas('status');

    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

it('validates forgot password request email format', function () {
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

it('rejects password reset with invalid token', function () {
    $user = makeAuthUser();

    $this->post(route('password.store'), [
        'token' => 'bad-token',
        'email' => $user->email,
        'password' => 'Newpass123!',
        'password_confirmation' => 'Newpass123!',
    ])->assertSessionHasErrors(['email']);
});

it('resets password with a valid token', function () {
    $user = makeAuthUser();
    $token = Password::createToken($user);

    $this->post(route('password.store'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'Newpass123!',
        'password_confirmation' => 'Newpass123!',
    ])->assertRedirect(route('login'));

    $user->refresh();

    expect(Hash::check('Newpass123!', $user->password))->toBeTrue();
});
