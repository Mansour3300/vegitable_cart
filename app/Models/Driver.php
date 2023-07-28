<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Driver extends User
{
    use HasFactory;
    protected $guarded= ['created_at','updated_at'];
}
