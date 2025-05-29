<?php

namespace App\Http\Controllers;

use App\Models\foods;
use App\Models\Orders;
use Illuminate\Http\Request;

class Foodsreservation extends Controller
{
    // Get all reservations
    public function getFoods()
    {
        $food = foods::with('order')->get();
        return response()->json($food);
    }

    // Add new reservation
    public function addFood(Request $request)
    {
        // Ensure this line is present and correct as shown below
        $validated = $request->validate([
            'orders_id' => 'required|exists:orders,id',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Orders::findOrFail($validated['orders_id']);
        $payment = $order->price * $validated['quantity'];

        $food = foods::create([
            'orders_id' => $validated['orders_id'],
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'payment' => $payment,
        ]);

        return response()->json($food, 201);
    }

    // Edit reservation by id
    public function editFoods(Request $request, $id)
    {
        $food = foods::findOrFail($id);

        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:1',
        ]);

        if (isset($validated['order_id'])) {
            $order = Orders::findOrFail($validated['order_id']);
        } else {
            $order = $food->order;
        }

        $newQuantity = $validated['quantity'] ?? $food->quantity;
        $newOrderId = $validated['order_id'] ?? $food->order_id;
        $payment = $order->price * $newQuantity;

        $food->update([
            'order_id' => $newOrderId,
            'name' => $validated['name'] ?? $food->name,
            'quantity' => $newQuantity,
            'payment' => $payment,
        ]);

        return response()->json($food);
    }

    // Delete reservation by id
    public function deleteFoods($id)
    {
        $food = Reservation::findOrFail($id);
        $food->delete();
        return response()->json(['message' => 'Food deleted successfully']);
    }
}