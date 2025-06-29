<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->decimal('monthly_return', 5, 2); // e.g., 20.00 for 20%
            $table->timestamps();
        });

        // Insert default plans
        DB::table('plans')->insert([
            ['name' => 'Starter Rs 5,000', 'price' => 5000, 'monthly_return' => 20.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Silver Rs 15,000', 'price' => 15000, 'monthly_return' => 20.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gold Rs 25,000', 'price' => 25000, 'monthly_return' => 20.00, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Platinum Rs 50,000', 'price' => 50000, 'monthly_return' => 20.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
