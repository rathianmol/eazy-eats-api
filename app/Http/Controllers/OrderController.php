<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Meal;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for the authenticated user.
     *
     * GET /api/v1/orders
     * Response:
     *
     *[
     *    {
     *        "id": 1,
     *        "total_price": 27.00,
     *        "meals": [
     *            { "id": 1, "name": "Bourbon Chicken", "price": 10.00, "quantity": 2 },
     *            { "id": 3, "name": "Morning Delight", "price": 7.00, "quantity": 1 }
     *        ]
     *    }
     *]
     */
    public function index()
    {
        $orders = Order::with(['meals' => function ($query) {
            $query->select('meals.id', 'name', 'price', 'quantity');
        }])
        ->where('user_id', auth()->id())
        ->get();

        return response()->json($orders);
    }

    /**
     * Store a newly created order with linked meals.
     *
     * POST /api/v1/orders
     * Payload:
     * {
     *  "meals": [
     *      { "id": 1, "quantity": 2 },
     *      { "id": 3, "quantity": 1 }
     *  ]
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meals' => 'required|array', // An array of meal IDs and quantities
            'meals.*.id' => 'required|exists:meals,id', // Validate each meal ID
            'meals.*.quantity' => 'required|integer|min:1', // Validate each meal quantity
        ]);

        // Create a new order for the authenticated user
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => 0, // We'll calculate this below
        ]);

        $totalPrice = 0;

        // Attach meals to the order and calculate the total price
        foreach ($validated['meals'] as $meal) {
            $mealModel = Meal::find($meal['id']);
            $quantity = $meal['quantity'];

            // Attach the meal to the order with quantity
            $order->meals()->attach($mealModel, ['quantity' => $quantity]);

            // Increment the total price
            $totalPrice += $mealModel->price * $quantity;
        }

        // Update the total price of the order
        $order->update(['total_price' => $totalPrice]);

        return response()->json(['message' => 'Order created successfully!', 'order' => $order->load('meals')]);
    }

    /**
     * Display the specified order for the authenticated user.
     *
     * GET /api/v1/orders/{id})
     */
    public function show($id)
    {
        $order = Order::with(['meals' => function ($query) {
            $query->select('meals.id', 'name', 'price', 'quantity');
        }])
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update the specified order.
     *
     * PUT /api/v1/orders/{id}
     * {
     *     "meals": [
     *         { "id": 2, "quantity": 3 }
     *     ]
     * }
     */
    public function update(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'meals' => 'sometimes|array', // Optional array of meals
            'meals.*.id' => 'required|exists:meals,id',
            'meals.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;

        // Update meals if provided
        if ($request->has('meals')) {
            $order->meals()->detach(); // Remove existing meals

            foreach ($validated['meals'] as $meal) {
                $mealModel = Meal::find($meal['id']);
                $quantity = $meal['quantity'];

                // Re-attach meals with new quantities
                $order->meals()->attach($mealModel, ['quantity' => $quantity]);

                // Update the total price
                $totalPrice += $mealModel->price * $quantity;
            }
        } else {
            $totalPrice = $order->total_price; // Retain the original price if meals aren't updated
        }

        // Update the order's total price
        $order->update(['total_price' => $totalPrice]);

        return response()->json(['message' => 'Order updated successfully!', 'order' => $order->load('meals')]);
    }

    /**
     * Remove the specified order for the authenticated user.
     *
     * DELETE /api/v1/orders/{id}
     */
    public function destroy($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully!']);
    }
}
