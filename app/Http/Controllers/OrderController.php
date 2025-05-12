<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Store a new order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user(); // Get the logged-in user

        // Validate the incoming order data
        $validatedData = $request->validate([
            'meals' => 'required|array',
            'meals.*.meal_id' => 'required|exists:meals,id',
            'meals.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate the total price and store meal details
        $totalPrice = 0;
        $mealsData = [];

        // Process meals and calculate total price
        foreach ($validatedData['meals'] as $meal) {
            $mealModel = Meal::find($meal['meal_id']);
            $mealsData[$meal['meal_id']] = $meal['quantity'];
            $totalPrice += $mealModel->price * $meal['quantity'];
        }

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'meals' => $mealsData, // Store meal IDs and quantities as JSON
            'total_price' => $totalPrice,
            'status' => 'pending', // Default status is 'pending'
        ]);

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order,
        ], 201);
    }

    /**
     * Display all orders for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userOrders()
    {
        $orders = Auth::user()->orders()->get();
        return response()->json($orders);
    }

    /**
     * Display a specific order by its ID.
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update an existing order status (e.g., from 'pending' to 'in_progress').
     *
     * @param int $orderId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validatedData = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $order->status = $validatedData['status'];
        $order->save();

        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order,
        ]);
    }

    /**
     * Soft delete an order (mark as deleted).
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($orderId)
    {
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete(); // Soft delete the order

        return response()->json(['message' => 'Order deleted successfully']);
    }

    /**
     * Restore a soft-deleted order.
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($orderId)
    {
        $order = Order::withTrashed()->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->restore(); // Restore the soft-deleted order

        return response()->json(['message' => 'Order restored successfully']);
    }

    /**
     * Permanently delete an order (force delete).
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete($orderId)
    {
        $order = Order::withTrashed()->find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->forceDelete(); // Permanently delete the order

        return response()->json(['message' => 'Order permanently deleted']);
    }
}
