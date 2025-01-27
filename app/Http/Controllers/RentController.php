<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentController extends Controller
{
    public function index()
    {
        return RentResource::collection(Rent::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Rent::storeRules());

        $rent = new Rent($validated);
        $rent->bike()->associate($validated['bike_id']);
        $rent->save();
        $rent->users()->sync($validated['user_ids']);

        return response()->json()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Rent $rent, Request $request)
    {
        $validated = $request->validate(Rent::updateRules());

        $rent->fill($validated);
        $rent->save();
        $rent->users()->sync($validated['user_ids']);

        return response()->json();
    }

    public function destroy(Rent $rent)
    {
        $rent->delete();

        return response()->json();
    }
}
