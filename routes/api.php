<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Foodsreservation; // Ensure this matches your controller's class name

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){

    // User Management Routes
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

    // Order Management Routes
    Route::get('/get-orders', [OrdersController::class, 'index']);
    Route::post('/add-orders', [OrdersController::class, 'store']);
    Route::get('/get-orders/{id}', [OrdersController::class, 'show']);
    Route::put('/edit-orders/{id}', [OrdersController::class, 'update']);
    Route::delete('/orders/{id}', [OrdersController::class, 'destroy']);

    // Foods Management Routes (Corrected method names)
    Route::get('/get-foods', [Foodsreservation::class, 'getFoods']); // Corrected 'getfoods' to 'getFoods'
    Route::post('/add-foods', [Foodsreservation::class, 'addFood']); // Corrected 'addfoods' to 'addFood'
    Route::put('/edit-foods/{id}', [Foodsreservation::class, 'editFoods']);
    Route::delete('/delete-foods/{id}', [Foodsreservation::class, 'deleteFoods']); // Corrected 'deletefoods' to 'deleteFoods'

    // Logout route
    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
