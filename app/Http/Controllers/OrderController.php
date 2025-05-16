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
        // xdebug_break();
        $user = Auth::user(); // Get the logged-in user

        // Validate the incoming order data
        $validatedData = $request->validate([
            'meals' => 'required|array', // meals should be an array
            'meals.*.meal_id' => 'required|exists:meals,id', // meal_id must exist in meals table
            'meals.*.quantity' => 'required|integer|min:1', // quantity should be an integer and at least 1
            'total_price' => 'required|numeric|min:0', // total price must be numeric and non-negative
        ]);

        // Calculate the total price and store meal details
        $totalPrice = 0;
        $mealsData = [];

        // Process meals and calculate total price
        foreach ($validatedData['meals'] as $meal) {
            $mealModel = Meal::find($meal['meal_id']); // Get the meal by its ID
            $mealsData[$meal['meal_id']] = $meal['quantity']; // Store the meal ID and its quantity
            $totalPrice += $mealModel->price * $meal['quantity']; // Calculate the total price based on meal price and quantity
        }

        // Create the order in the database
        $order = Order::create([
            'user_id' => $user->id, // Associate the order with the logged-in user
            'meals' => $mealsData,  // Store meals and quantities as a JSON object
            'total_price' => $totalPrice,  // Store the total price of the order
            'status' => 'pending',
        ]);

        // Return the response indicating success
        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order, // Return the created order
        ], 201);
    }

    /**
     * Display all orders for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userOrders()
    {
         $user = Auth::user();

        // Paginate orders for the authenticated user (10 orders per page for example)
        // Automatically handles pagination based on `page` query parameter.
        $orders = $user->orders()->latest()->paginate(10);

        // Prepare data to send to the front-end
        $ordersData = $orders->map(function ($order) {
            $mealDetails = [];
            $totalPrice = 0;

            foreach ($order->meals as $mealId => $quantity) {
                $meal = Meal::find($mealId);

                if ($meal) {
                    $mealDetails[] = [
                        'meal_id' => $mealId,
                        'title' => $meal->title,
                        'quantity' => $quantity,
                        'price' => $meal->price * $quantity,
                    ];
                    $totalPrice += $meal->price * $quantity;
                }
            }

            return [
                'order_id' => $order->id,
                'status' => $order->status,
                'meals' => $mealDetails,
                'total_price' => $totalPrice,
                'order_date' => $order->created_at->format('F j, Y, g:i a'), // Human-readable date
            ];
        });

        // Include pagination metadata
        return response()->json([
            'orders' => $ordersData,
            'pagination' => [
                'total' => $orders->total(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
            ]
        ]);
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

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404); // Return 404 if the order is not found
        }

        return response()->json($order); // Return the order details as JSON
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
        $order = Order::find($orderId); // Find the order by its ID

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404); // Return 404 if the order is not found
        }

        // Validate the incoming status update
        $validatedData = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled', // Valid status options
        ]);

        // Update the order's status
        $order->status = $validatedData['status'];
        $order->save(); // Save the changes

        // Return the response indicating success
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
        $order = Order::find($orderId); // Find the order by its ID

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404); // Return 404 if the order is not found
        }

        // Soft delete the order
        $order->delete();

        // Return a success message
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
        $order = Order::withTrashed()->find($orderId); // Retrieve the soft-deleted order

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404); // Return 404 if the order is not found
        }

        // Restore the soft-deleted order
        $order->restore();

        // Return a success message
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
        $order = Order::withTrashed()->find($orderId); // Retrieve the soft-deleted order

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404); // Return 404 if the order is not found
        }

        // Permanently delete the order
        $order->forceDelete();

        // Return a success message
        return response()->json(['message' => 'Order permanently deleted']);
    }
}
