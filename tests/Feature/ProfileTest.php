<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create(['role' => 'CUSTOMER']);

    $response = $this
        ->actingAs($user)
        ->get('/customer/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create(['role' => 'CUSTOMER']);

    $response = $this
        ->actingAs($user)
        ->patch('/customer/profile', [
            'fname' => 'Test',
            'lname' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/customer/profile');

    $user->refresh();

    $this->assertSame('Test', $user->fname);
    $this->assertSame('User', $user->lname);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create(['role' => 'CUSTOMER']);

    $response = $this
        ->actingAs($user)
        ->patch('/customer/profile', [
            'fname' => 'Test',
            'lname' => 'User',
            'username' => $user->username,
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/customer/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create(['role' => 'CUSTOMER']);

    $response = $this
        ->actingAs($user)
        ->delete('/customer/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create(['role' => 'CUSTOMER']);

    $response = $this
        ->actingAs($user)
        ->from('/customer/profile')
        ->delete('/customer/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/customer/profile');

    $this->assertNotNull($user->fresh());
});
