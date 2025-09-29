<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Get all users
    public function index()
    {
        return User::all();
    }

    // Get one user by id
    public function show($id)
    {
        return User::findOrFail($id);
    }

    // Create new user
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            // Add other fields and rules here
        ]);
        // Create user
        $user = User::create($data);
        return response()->json($user, 201);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
