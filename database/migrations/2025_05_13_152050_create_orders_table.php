<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Orders;

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
            $table->timestamps();
        });


          $orders = [
            ['name' => 'Burger'],
            ['name' => 'Fries'],
            ['name' => 'Chicken'],
            ['name' => 'BeefSteak'],
            ['name' => 'Coke'],
            ['name' => 'Sprite'],
            ['name' => 'Nestea'],
            
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
