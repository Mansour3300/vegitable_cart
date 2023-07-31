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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('phone');
            $table->string('image');
            $table->string('city');
            $table->string('address');
            $table->string('identity');
            $table->string('email');
            $table->string('password');
            $table->string('country_key');
            $table->enum('verify',['verified','not_verified'])->default('not_verified');
            $table->integer('otp_code')->unique();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
