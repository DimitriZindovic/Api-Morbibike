<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SupplementBacon\LaravelAPIToolkit\Http\Resources\PaginatedCollection;
use SupplementBacon\LaravelPaginable\Requests\IndexPaginatedRequest;
use Symfony\Component\HttpFoundation\Response;

class RentController extends Controller
{
    public function index(IndexPaginatedRequest $request)
    {
        $items = Rent::paginator($request);
        return new PaginatedCollection($items, RentResource::class);
    }
    public function store(Request $request)
    {
        $validated = $request->validate(Rent::storeRules());

        DB::transaction(function () use ($validated) {
            $rent = new Rent($validated);
            $rent->save();

            foreach ($validated['users'] as $userBike) {
                $rent->users()->attach($userBike['user'], ['bike_id' => $userBike['bike']]);
            }
        });


        return response()->json()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Rent $rent, Request $request)
    {
        $validated = $request->validate(Rent::updateRules());

        DB::transaction(function () use ($validated, $rent) {
            $rent->fill($validated);
            $rent->save();

            $rent->users()->detach();
            foreach ($validated['users'] as $userBike) {
                $rent->users()->attach($userBike['user'], ['bike_id' => $userBike['bike']]);
            }
        });

        return response()->json();
    }

    public function destroy(Rent $rent)
    {
        $rent->delete();

        return response()->json();
    }
}
