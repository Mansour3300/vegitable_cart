<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public static function total_price(){
        $basket_items = DB::table('basket_items')
                            ->join('products','products.id','=','basket_items.product_id')
                            ->select('basket_items.*','products.price_kilo')
                            ->get();

                            $total_one =0;
                    foreach($basket_items as $basket_item){
                        // dump($basket_item);
                          $count = $basket_item->count;
                          $price = $basket_item->price_kilo;
                          $total_one += $count * $price;
                            }
                return $total_one;
}
}
