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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('password');
            $table->enum('role',['admin','user'])->default('User');
            $table->string('image')->nullable();
            $table->string('phone')->unique();
            $table->enum('verify',['verified','not_verified'])->default('not_verified');
            $table->string('city');
            $table->string('country_key');
            $table->integer('otp_code')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
