<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\PayRequest;
use App\Notifications\OrderNotification;
use App\Http\Resources\DriverOrderResource;
use App\Http\Requests\Driver\PickOrderRequest;

class DriverOrderController extends Controller
{
    public function allOrders(){
        $users = DB::table('users')
                             ->join('orders','user_id','users.id')
                             ->select('orders.*','user_name')
                             ->where('status','ready')
                             ->orwhere('status','preparing')
                             ->get();
        // dd($users);
        $data = DriverOrderResource::collection($users);
        return response()->json(['status'=>'success','data'=>$data]);
    }


    /*------------------------------------------------------------------------------------- */
                            //to pick order to deliver


    public function pickOrder($id){
         $check = Order::findorfail($id);
         if($check->driver_id == null){
            $check->update(['driver_id'=>auth()->guard('driver')->id()]);
            return response()->json(['status'=>'success','data'=>$check]);
         }else{
            return response()->json(['status'=>'failed','message'=>'this order is not avilable']);
         }
    }

    /*---------------------------------------------------------------------------------------*/
                            //to update oredr status

    public function updateStatus(OrderRequest $request, $id)
    {
        $request->validated();
        $update = Order::findorfail($id);
        // dd($update);
        if($request->status == 'in delivery'){
            $update->update(['status'=>'in_delivery']);
            $order = Order::where('id',$id)->first();
            $user1 = User::where('id',$order->user_id)->first();
            // dd($user1);
            $user1->notify(new OrderNotification($order));
            return response()->json(['success'=>'true','message'=>'your order is in delivery']);
        }elseif($request->status == 'finished'){
            $update->update(['status'=>'finished']);
            return response()->json(['success'=>'true','message'=>'your order is now delivered']);
        }
    }


    /*-------------------------------------------------------------------------------------------*/
                                        // cash money

    public function payedMoney(PayRequest $request,$id){
        $request->validated();
        $payed = Order::findorfail($id);
        $payed->update(['payed'=>$request->payed]);
        return response()->json(['success'=>'true','message'=>'you added payed money for order']);
    }


    /*-------------------------------------------------------------------------------------------- */


    public function driverlocation(){
        $orders = Order::get();
            foreach($orders as $order){
                $lat = Order::first()->latitude;
                $lon = Order::first()->longitude;
                $driver = Driver::select("drivers.id",
                                      DB::raw("6371 * acos(cos(radians(" . $lat . "))
                                      *cos(radians(drivers.latitude))
                                      *cos(radians(drivers.longitude) - radians(" .$lon . "))
                                      + sin(radians(" .$lat. "))
                                      *sin(radians(drivers.latitude))) AS distance"))
                            ->first();
            if($driver->distance >= 500){
                return $orders;
            }
                            // dd($driver->distance);
    }
    }
}
