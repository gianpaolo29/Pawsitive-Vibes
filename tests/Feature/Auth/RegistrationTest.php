<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'NewPass123!',
        'password_confirmation' => 'NewPass123!',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('welcome', absolute: false));
});
