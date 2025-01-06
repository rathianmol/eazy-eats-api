<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Meal Routes for logged in User
    Route::get('/meals', [MealController::class, 'index']); // View all meals
    Route::get('/meals/{id}', [MealController::class, 'show']); // View a specific meal

    // Admin Meal Routes
    Route::middleware('role:admin')->group(function () {
        Route::post('/meals', [MealController::class, 'store']); // Create a meal
        Route::put('/meals/{id}', [MealController::class, 'update']); // Update a meal
        Route::delete('/meals/{id}', [MealController::class, 'destroy']); // Delete a meal
    });
});