<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use App\Http\Resources\BikeResource;
use Symfony\Component\HttpFoundation\Response;

class BikeController extends Controller
{
    public function index()
    {
        return BikeResource::collection(Bike::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Bike::storeRules());

        $bike = new Bike($validated);
        $bike->save();

        return response()->json()->setStatusCode(Response::HTTP_CREATED);
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
