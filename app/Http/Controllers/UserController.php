<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use SupplementBacon\LaravelAPIToolkit\Http\Resources\PaginatedCollection;
use SupplementBacon\LaravelPaginable\Requests\IndexPaginatedRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(IndexPaginatedRequest $request)
    {
        $items = User::paginator($request);
        return new PaginatedCollection($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(User::storeRules());

        $user = new User($validated);
        $user->save();

        return response()->json()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(User $user, Request $request)
    {
        $validated = $request->validate(User::updateRules());

        $user->fill($validated);
        $user->save();

        return response()->json();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json();
    }
}
