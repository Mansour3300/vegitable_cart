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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignid('driver_id')->constraind('drivers')->cascadeondelete();
            $table->string('driver_liscense_image');
            $table->string('car_liscense_image');
            $table->string('car_insurance_image');
            $table->string('car_front_image');
            $table->string('car_back_image');
            $table->string('car_type');
            $table->string('car_model');
            $table->string('bank_name');
            $table->string('bank_account');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
