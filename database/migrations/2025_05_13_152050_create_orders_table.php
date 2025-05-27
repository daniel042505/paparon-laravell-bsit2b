<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Orders; // Ensure your model name is correct

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price'); // Changed to integer as requested
            $table->timestamps();
        });

        // Corrected data seeding with 'name' and integer 'price' for each order
        $orders = [
            ['name' => 'Burger', 'price' => 30],
            ['name' => 'Fries', 'price' => 20],
            ['name' => 'Chicken', 'price' => 50],
            ['name' => 'BeefSteak', 'price' => 150], // Example price
            ['name' => 'Coke', 'price' => 25],
            ['name' => 'Sprite', 'price' => 25],
            ['name' => 'Nestea', 'price' => 20],
            ['name' => 'Pizza', 'price' => 250], // Added new item for demonstration
        ];

        foreach($orders as $order){
            Orders::create($order);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
