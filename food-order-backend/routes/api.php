<?
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'getProfile']);
    Route::put('/user', [UserController::class, 'updateProfile']);

    Route::get('/foods', [FoodController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::post('/reviews', [ReviewController::class, 'store']);
});

Route::middleware('auth:api', 'admin')->group(function () {
    Route::post('/foods', [FoodController::class, 'store']);
    Route::put('/foods/{id}', [FoodController::class, 'update']);
    Route::delete('/foods/{id}', [FoodController::class, 'destroy']);

    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
});
