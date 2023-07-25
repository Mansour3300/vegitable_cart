<?php

namespace App\Models;

use App\Models\Rate;
use App\Models\Basket;
use App\Models\Category;
use App\Models\BasketItem;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded= ['created_at','updated_at'];


    public function category(){
        return $this->belongsto(Category::class);
    }


    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function bask(){
        return $this->belongstoMany(Basket::class,'basket_items');

    }

    public function rate(){
        return $this->hasmany(Rate::class);
    }

}
