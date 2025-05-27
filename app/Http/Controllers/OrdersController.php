<?php

namespace App\Http\Controllers;

use App\Models\Orders; // Make sure this matches your model name (Orders.php)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Useful for logging errors

class OrdersController extends Controller // Note the 's' in OrdersController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all orders from the database
        $orders = Orders::all();

        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * (Typically not used in a pure API context)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json(['message' => 'Ready to create a new order'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data, now including 'price'
        $request->validate([
            'name' => 'required|string|max:255|unique:orders', // 'name' must be unique in the 'orders' table
            'price' => 'required|numeric|min:0', // Added validation for price
        ]);

        try {
            // Create a new Order instance and fill it with the validated data
            $order = Orders::create([
                'name' => $request->input('name'),
                'price' => $request->input('price'), // <--- PRICE ADDED HERE
            ]);

            return response()->json([
                'message' => 'Order "' . $order->name . '" added successfully!',
                'data' => $order
            ], 201); // 201 Created status code

        } catch (\Exception $e) {
            Log::error('Error adding order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to add order. Please try again.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }

        return response()->json([
            'message' => 'Order retrieved successfully',
            'data' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * (Typically not used in a pure API context)
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found!'], 404);
        }
        
        return response()->json([
            'message' => 'Order data for editing',
            'data' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data, now including 'price'
        $request->validate([
            'name' => 'required|string|max:255|unique:orders,name,' . $id, // 'name' must be unique, excluding the current order's ID
            'price' => 'required|numeric|min:0', // Added validation for price
        ]);

        try {
            $order = Orders::find($id);

            if (!$order) {
                return response()->json(['message' => 'Order not found!'], 404);
            }

            $order->update([
                'name' => $request->input('name'),
                'price' => $request->input('price'), // <--- PRICE ADDED HERE
            ]);

            return response()->json([
                'message' => 'Order "' . $order->name . '" updated successfully!',
                'data' => $order
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update order. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $order = Orders::find($id);

            if (!$order) {
                return response()->json(['message' => 'Order not found!'], 404);
            }

            $order->delete();

            return response()->json(['message' => 'Order successfully deleted!'], 200); 

        } catch (\Exception | \Throwable $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete order. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
