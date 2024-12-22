<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['user' => $user, 'token' => JWTAuth::fromUser($user)]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function getProfile()
    {
        return response()->json(auth()->user());
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->update($request->only('name', 'email'));
        return response()->json(['user' => $user]);
    }
}
