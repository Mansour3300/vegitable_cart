<?php

namespace App\Models;

use App\Models\User;
use App\Models\BasketItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Basket extends Model
{
    use HasFactory;

    protected $guarded= ['created_at','updated_at'];

    // public function user(){
    //     return $this->belongsto(User::class);
    // }

    public function basketitem(){
        return $this->hasMany(BasketItem::class);
    }


    public function prod(){
        return $this->belongstoMany(Product::class,'basket_items');

    }
}
