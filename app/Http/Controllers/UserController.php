<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate(User::storeRules());

        $user = new User($validated);
        $user->save();

        return response()->json();
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
