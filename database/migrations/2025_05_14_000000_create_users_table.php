<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('user_status_id')->constrained('user_statuses')->onDelete('cascade');
            $table->string('first_name');
             $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

            $users = [
            [
                'first_name' => 'Manager',
                'last_name' => 'Manager',
                'email' => 'Manager@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'user_status_id' => 1,
            ],
                

             [
                'first_name' => 'Cashier',
                'last_name' => 'cashier',
                'email' => 'cashier@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'user_status_id' => 2,
            ],

        ];

        foreach($users as $user){
            User::create($user);



        }
    }

    





    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
