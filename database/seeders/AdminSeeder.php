<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'user_name'=>'Admin',
            'phone'=>'01000000000',
            'city'=>'mansoura',
            'password'=>123456789,
            'role'=>'admin',
            'country_key'=>'02',
            'verify'=>'verified',
            'otp_code'=>1111]);
    }
}
