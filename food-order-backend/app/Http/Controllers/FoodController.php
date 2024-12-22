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
class FoodController extends Controller
{
    public function index()
    {
        return response()->json(Food::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
        ]);

        $food = Food::create($validated);
        return response()->json($food);
    }

    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $food->update($request->only('name', 'description', 'price', 'image'));
        return response()->json($food);
    }

    public function destroy($id)
    {
        Food::destroy($id);
        return response()->json(['message' => 'Food deleted successfully']);
    }
}