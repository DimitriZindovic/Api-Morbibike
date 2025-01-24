<?php

use App\Models\Bike;
use App\Models\Rent;
use App\Models\User;

test('can list rents', function () {
    $response = $this->get('/rents');

    $response->assertStatus(200);
});

test('can create rent', function () {
    $count = Rent::count();
    $response = $this->post('/rents', [
        'bike_id' => Bike::first()->id,
        'name' => 'Rent name',
        'start_date' => '2025-01-24',
        'end_date' => '2025-01-25',
        'user_id' => [User::inRandomOrder()->first()->id, User::inRandomOrder()->first()->id],
    ]);
    $response->assertStatus(200);

    expect(Rent::count())->toBe($count + 1);
});

test('can update rent', function () {
    $rent = Rent::first();
    $response = $this->put("/rents/{$rent->id}", [
        'bike_id' => Bike::first()->id,
        'name' => 'Rent name updated',
        'start_date' => '2025-01-24',
        'end_date' => '2025-01-26',
        'user_id' => [User::inRandomOrder()->first()->id, User::inRandomOrder()->first()->id],
    ]);

    $response->assertStatus(200);
});

test('can delete rent', function () {
    $count = Rent::count();
    $rent = Rent::first();
    $response = $this->delete("/rents/{$rent->id}");
    $response->assertStatus(200);

    expect(Rent::count())->toBe($count - 1);
});
