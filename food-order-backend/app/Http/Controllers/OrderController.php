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
class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => collect($validated['items'])->sum(fn($item) => Food::find($item['food_id'])->price * $item['quantity']),
        ]);

        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['food_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return response()->json($order);
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->with('items.food')->get();
        return response()->json($orders);
    }
}
