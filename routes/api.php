<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController; // Changed from OrderController to OrdersController to match your selected code


Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){

    // User Management Routes
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

    // Order Management Routes (New additions)
    Route::get('/orders', [OrdersController::class, 'index']); // Get all orders
    Route::post('/orders', [OrdersController::class, 'store']); // Add a new order
    Route::get('/orders/{id}', [OrdersController::class, 'show']); // Get a specific order
    Route::put('/orders/{id}', [OrdersController::class, 'update']); // Update an existing order
    Route::delete('/orders/{id}', [OrdersController::class, 'destroy']); // Delete an order

    // Logout route
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});

