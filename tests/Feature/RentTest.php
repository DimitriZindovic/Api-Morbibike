<?php

use App\Models\Bike;
use App\Models\Rent;
use App\Models\User;

test('can list rents', function () {
    $response = $this->get('/rents');

    $response->assertStatus(200);
});

test('can create rent', function () {
    $rent = Rent::first();
    $bike = Bike::first();
    $users = User::inRandomOrder()->take(2)->get();

    $response = $this->post("/rents", [
        'bike_id' => $bike->id,
        'name' => 'Rent name updated',
        'start_date' => '2025-01-24',
        'end_date' => '2025-01-26',
        'user_ids' => $users->pluck('id')->toArray(),
    ]);

    $response->assertStatus(201);

    $rent = Rent::latest()->first();

    expect($rent->bike->id)->toBe($bike->id);
    expect($rent->users->pluck('id')->toArray())->toBe($users->pluck('id')->toArray());
});

test('can update rent', function () {
    $rent = Rent::first();
    $bike = Bike::first();
    $users = User::inRandomOrder()->take(2)->get();

    $response = $this->put("/rents/{$rent->id}", [
        'bike_id' => Bike::first()->id,
        'name' => 'Rent name updated',
        'start_date' => '2025-01-24',
        'end_date' => '2025-01-26',
        'user_ids' => $users->pluck('id')->toArray(),
    ]);

    $response->assertStatus(200);

    $rent->refresh();

    expect($rent->bike->id)->toBe($bike->id);
    expect($rent->users->pluck('id')->toArray())->toBe($users->pluck('id')->toArray());
});

test('can delete rent', function () {
    $count = Rent::count();
    $rent = Rent::first();
    $response = $this->delete("/rents/{$rent->id}");
    $response->assertStatus(200);

    expect(Rent::count())->toBe($count - 1);
});
