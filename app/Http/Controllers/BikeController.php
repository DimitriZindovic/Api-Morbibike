<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;
use App\Http\Resources\BikeResource;
use SupplementBacon\LaravelAPIToolkit\Http\Resources\PaginatedCollection;
use SupplementBacon\LaravelPaginable\Requests\IndexPaginatedRequest;
use Symfony\Component\HttpFoundation\Response;

class BikeController extends Controller
{
    public function index(IndexPaginatedRequest $request)
    {
        $items = Bike::paginator($request);
        return new PaginatedCollection($items);
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
