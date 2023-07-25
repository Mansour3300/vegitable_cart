<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Basket;
use App\Models\Product;
use App\Models\BasketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BasketRequest;
use App\Http\Resources\BasketResource;
use App\Http\Requests\DiscountCodeRequest;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all= Basket::where('user_id',auth()->id())->first();
        $data = BasketResource::make($all);
        // $data=$all->prod;
        return response()->json(['success'=>'true','all items in the basket'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BasketRequest $request)
    {
        $valied = $request->validated();

        $cart = BasketItem::where(['basket_id'=>auth()->id(),'product_id'=>$request->product_id])->first();
        $basket = Basket::where('id',auth()->id())->first();
            // dd($basket);
        if($basket==null){
            Basket::create(['user_id'=>auth()->id(),'id'=>auth()->id()]);
        }
        // dd($basket);
        if($cart){
            $cart->update([
                'count'=>$cart->count + $request->count,
            ]);
            return response()->json(['success'=>'true','message'=>'count updated','now'=>$cart]);
        }else{
            $valied['basket_id']=auth()->id();
            $new = BasketItem::create($valied);
            return response()->json(['success'=>'true','message'=>'add to cart','now'=>$new]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BasketItem::findorfail($id)->delete();
        return response()->json(['success'=>'true','message'=>'your cart is deleted']);
    }

    /**
     *  add one more count
     */

    public function add_one($id){
        $product = BasketItem::where(['basket_id'=>auth()->id(),'product_id'=>$id])->first();
        $product->update(['count'=>$product->count + 1]);
        $cart = BasketItem::where('basket_id',auth()->id())->get();
        return response()->json(['success'=>'true','message'=>'you added one more',$cart]);
     }
     /***
      *
      */
    public function remove_one($id){
        $product = BasketItem::where(['basket_id'=>auth()->id(),'product_id'=>$id])->first();
        $product->update(['count'=>$product->count - 1]);
        $cart = BasketItem::where('basket_id',auth()->id())->get();
        return response()->json(['success'=>'true','message'=>'you removed one count',$cart]);
}
    /***
     *
     */
     public function total_price(Request $request){
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
                return response()->json(['success'=>'true','total price'=>$total_one]);

     }


}

