<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    public function index()
    {
        return Bike::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Bike::storeRules());

        $bike = new Bike($validated);
        $bike->save();

        return response()->json();
    }

    public function update(Bike $bike, Request $request)
    {
        $validated = $request->validate(Bike::updateRules());

        $bike->fill($validated);
        $bike->save();

        return response()->json();
    }

    public function destroy(Bike $bike)
    {
        $bike->delete();

        return response()->json();
    }
}
