<?php

namespace App\Models;

use App\Models\Basket;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded= ['created_at','updated_at'];


    public function products(){
        return $this->hasMany(Product::class);
    }


}
