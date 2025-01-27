<?php

use App\Models\User;

test('can list users', function () {
    $response = $this->get('/users');

    $response->assertStatus(200);
});

test('can create user', function () {
    $count = User::count();
    $response = $this->post('/users', [
        'name' => 'User name',
        'surname' => 'User surname',
    ]);
    $response->assertStatus(201);

    expect(User::count())->toBe($count + 1);
});
