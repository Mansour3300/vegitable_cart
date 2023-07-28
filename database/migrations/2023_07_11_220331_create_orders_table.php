<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignid('user_id')->constraind('users')->cascadeondelete();
            // $table->foreignid('basket_id')->constraind('baskets')->cascadeondelete();
            $table->enum('status',['binding','preparing','in_delivery','canceled','finished','ready'])->default('binding');
            $table->string('total_price');
            $table->string('order_code');
            $table->json('details')->nullable();
            $table->string('address');
            $table->string('payment');
            $table->date('delivery_date');
            $table->time('delivery_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
