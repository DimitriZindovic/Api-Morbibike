<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    public function index()
    {
        return Rent::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Rent::storeRules());

        $rent = new Rent($validated);
        $rent->save();
        $rent->users()->sync($validated['user_id']);

        return response()->json();
    }

    public function update(Rent $rent, Request $request)
    {
        $validated = $request->validate(Rent::updateRules());

        $rent->fill($validated);
        $rent->save();
        $rent->users()->sync($validated['user_id']);

        return response()->json();
    }

    public function destroy(Rent $rent)
    {
        $rent->delete();

        return response()->json();
    }
}
