<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Basket;
use App\Models\BasketItem;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\BasketResource;
use App\Http\Requests\OrderStoreRequest;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //note orders fo auth user
    {
        $all = Order::where('user_id',auth()->id())->
                      where('status',['binding','preparing','in_delivery'])
                      ->get();
        $order = OrderResource::collection($all);
        return response()->json(['success'=>'true','current orders'=>$order]);
    }

    /**
     * Store a newly created resource in storage.
     */

        public function store(OrderStoreRequest $request){
            $valied = $request->validated();
            $valied['order_code'] = '#'.rand(0000,9999);
            $valied['user_id']= auth()->id();
            $valied['status']= 'binding';
            $valied['total_price'] = PriceController::total_price();
            $basket = Basket::where('user_id',auth()->id())->first();
            $valied['details'] =BasketResource::make($basket);
            $order = Order::create($valied);
            Basket::where('user_id',auth()->id())->delete();
            BasketItem::where('basket_id',auth()->id())->delete();
            $order1 = OrderResource::make($order);
            return response()->json(['sucess'=>'true','order'=>$order1]);

        }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $all = Order::where('status',['canceled','finished'])->get();
        $order = OrderResource::collection($all);
        return response()->json(['success'=>'true','finished orders'=>$all]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        $request->validated();
        $update = Order::findorfail($id);
        if($request->status == 'preparing'){
            $update->update(['status'=>'preparing']);
            $order = Order::where('id',$id)->first();
            $user1 = User::where('id',$order->user_id)->first();
            // dd($user1);
            $user1->notify(new OrderNotification($order));
            return response()->json(['success'=>'true','message'=>'your order is in preparation']);
        }elseif($request->status == 'ready'){
            $update->update(['status'=>'ready']);
            $order = Order::where('id',$id)->first();
            $user1 = User::where('id',$order->user_id)->first();
            // dd($user1);
            // $user1->notify(new OrderNotification($order));
            return response()->json(['success'=>'true','message'=>'your order is ready']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Order::findorfail($id)->update(['status'=>'canceled']);
        return response()->json(['success'=>'true','message'=>'your order is cancelled']);
    }
}
