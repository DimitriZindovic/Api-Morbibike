<?php

use App\Models\Bike;

test('can list bikes', function () {
    $response = $this->get('/bikes');

    $response->assertStatus(200);
});

test('can create bikes', function () {
    $count = Bike::count();
    $response = $this->post('/bikes', [
        'name' => 'Bike name',
        'color' => 'Bike color',
        'type' => 'Bike type',
    ]);
    $response->assertStatus(200);

    expect(Bike::count())->toBe($count + 1);
});

test('can update bike', function () {
    $bike = Bike::first();
    $response = $this->put("/bikes/{$bike->id}", [
        'name' => 'Bike name updated',
        'color' => 'Bike color updated',
        'type' => 'Bike type updated',
    ]);

    $response->assertStatus(200);
});

test('can delete bike', function () {
    $count = Bike::count();
    $bike = Bike::first();
    $response = $this->delete("/bikes/{$bike->id}");
    $response->assertStatus(200);

    expect(Bike::count())->toBe($count - 1);
});
