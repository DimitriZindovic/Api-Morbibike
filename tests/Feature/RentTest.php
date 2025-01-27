<?php

use App\Models\Bike;
use App\Models\Rent;
use App\Models\User;

test('can list rents', function () {
    $response = $this->get('/rents?pagination%5Bcurrent%5D=1&pagination%5BpageSize%5D=1');

    $response->assertStatus(200);
});

test('can create rent', function () {
    $users = User::inRandomOrder()->take(2)->get()->pluck('id')->toArray();
    var_dump($users);
    $bikes = Bike::inRandomOrder()->take(2)->get()->pluck('id')->toArray();
    $response = $this->post("/rents", [
        'name' => 'Rent name',
        'start_date' => '2025-01-24',
        'end_date' => '2025-01-26',
        'users' => [
            ['user' => $users[0], 'bike' =>  $bikes[0]],
            ['user' => $users[1], 'bike' =>  $bikes[1]],
        ],
    ]);

    $response->assertStatus(201);

    $rent = Rent::latest()->first();
    var_dump($rent->users->pluck('id')->toArray());

    expect($rent->users->pluck('id')->toArray())->toBe($users);
    expect($rent->users->pluck('pivot.bike_id')->toArray())->toBe($bikes);
});

test('can update rent', function () {
    $rent = Rent::first();
    $users = User::inRandomOrder()->take(2)->get()->pluck('id')->toArray();
    $bikes = Bike::inRandomOrder()->take(2)->get()->pluck('id')->toArray();

    $response = $this->put("/rents/{$rent->id}", [
        'name' => 'Rent name updated',
        'start_date' => '2025-01-24',
        'end_date' => '2025-01-26',
        'users' => [
            ['user' => $users[0], 'bike' =>  $bikes[0]],
            ['user' => $users[1], 'bike' =>  $bikes[1]],
        ],
    ]);

    $response->assertStatus(200);

    $rent->refresh();

    expect($rent->users->pluck('id')->toArray())->toBe($users);
    expect($rent->users->pluck('pivot.bike_id')->toArray())->toBe($bikes);
});

test('can delete rent', function () {
    $count = Rent::count();
    $rent = Rent::first();
    $response = $this->delete("/rents/{$rent->id}");
    $response->assertStatus(200);

    expect(Rent::count())->toBe($count - 1);
});
