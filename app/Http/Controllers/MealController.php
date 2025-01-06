<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Get all available meals.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $meals = Meal::where('is_available', true)->get(); // Fetch only available meals
        return response()->json($meals, 200);
    }

    /**
     * Get a single meal.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $meal = Meal::find($id);

        if (!$meal) {
            return response()->json(['message' => 'Meal not found'], 404);
        }

        return response()->json($meal, 200);
    }

    /**
     * Create a new meal (Admin only).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $meal = Meal::create($validated);

        return response()->json(['message' => 'Meal created successfully', 'meal' => $meal], 201);
    }

    /**
     * Update an existing meal (Admin only).
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $meal = Meal::find($id);

        if (!$meal) {
            return response()->json(['message' => 'Meal not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $meal->update($validated);

        return response()->json(['message' => 'Meal updated successfully', 'meal' => $meal], 200);
    }

    /**
     * Delete a meal (Admin only).
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $meal = Meal::find($id);

        if (!$meal) {
            return response()->json(['message' => 'Meal not found'], 404);
        }

        $meal->delete();

        return response()->json(['message' => 'Meal deleted successfully'], 200);
    }
}
