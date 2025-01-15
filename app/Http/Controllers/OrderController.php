<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
        /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with('user')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string',
        ]);

        $order = Order::create($validated);

        return response()->json(['message' => 'Order created successfully!', 'order' => $order]);
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('user')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $validated = $request->validate([
            'total_price' => 'nullable|numeric|min:0',
            'status' => 'nullable|string',
        ]);

        $order->update($validated);

        return response()->json(['message' => 'Order updated successfully!', 'order' => $order]);
    }

    /**
     * Remove the specified order.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully!']);
    }
}
