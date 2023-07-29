<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverOrderResource;

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

    /*---------------------------------------------------------------------------------------*/
}
