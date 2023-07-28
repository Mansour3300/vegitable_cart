<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverOrderController extends Controller
{
    public function allOrders(){
        $orders = Order::where('status','ready')->orwhere('status','preparing')->first();
        $orders->ordr();
        // dd($data);
        return response()->json(['status'=>'success','data'=>$orders]);
    }
}
