<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Version 1 API Routes
Route::prefix('v1')->group(function () {

    // Routes for all authenticated users
    Route::middleware('auth:sanctum')->group(function () {
        // Meal Routes for logged-in users
        Route::get('/meals', [MealController::class, 'index']); // View all meals
        Route::get('/meals/{id}', [MealController::class, 'show']); // View a specific meal
    });

    // Admin Routes
    Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
        // Meal Management for admin users
        Route::post('/meals', [MealController::class, 'store']); // Create a meal
        Route::put('/meals/{id}', [MealController::class, 'update']); // Update a meal
        Route::delete('/meals/{id}', [MealController::class, 'destroy']); // Delete a meal
    });

    // Super Admin Routes (Optional, if needed)
    Route::middleware(['auth:sanctum', 'role:super-admin'])->prefix('super-admin')->group(function () {
        // Additional routes for super-admin if necessary, e.g. user management
        // Example: Route::post('/users', [UserController::class, 'create']);
    });
});
