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

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_id' => 'required|exists:foods,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create([
            'user_id' => auth()->id(),
            'food_id' => $validated['food_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json($review);
    }
}