<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BasketItem extends Model
{
    use HasFactory;

    protected $guarded= ['created_at','updated_at'];


    public function items(){
        return $this->hasMany(Product::class);
    }


    // public function basket(){
    //     return $this->hasone(Basket::class);
    // }
}
