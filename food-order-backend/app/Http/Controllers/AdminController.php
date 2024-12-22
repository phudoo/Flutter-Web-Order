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

class AdminController extends Controller
{
    public function deleteUser($id)
    {
        User::destroy($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
