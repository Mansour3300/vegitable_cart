<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Driver;
use App\Http\Resources\InfoResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Driver\CarRequest;
use App\Http\Requests\DrivrLoginRequest;
use App\Http\Requests\UpdateinfoRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Driver\ForgotRequest;
use App\Http\Resources\NotificationResource;
use App\Http\Requests\Driver\CarUpdateRequest;
use App\Http\Requests\Driver\ResetPassRequest;
use App\Http\Requests\DriverVerifyAccountRequest;
use App\Http\Requests\Driver\ResetPassCodeRequest;
use App\Http\Requests\Driver\DriverUpdateinfoRequest;
use App\Http\Requests\Driver\DriverRegisterationRequest;
// use App\Notifications\ForgotPassOtpNotification;


class DriverAuthController extends Controller
{

    public function driverRegister(DriverRegisterationRequest $request){
        $newuser= $request->validated();
        $newuser['password']=Hash::make($newuser['password']);
        $newuser['image']= $request->file('image')->store('image','public');
        $newuser['otp_code']=rand(0000,9999);
        $user=Driver::create($newuser);
            return response()->json(['status'=>'success','message'=>'yor are now registered']);

}
/*-----------------------------------------------------------------------------------------*/


public function car(CarRequest $request){
        $newcar = $request->validated();
        $id = Driver::where('phone',$request->phone)->first();
        $driver_id = $id->id;
        // dd($id->id);
        $newcar['id']=$driver_id;
        $newcar['driver_id'] = $driver_id;
        $newcar['driver_liscense_image'] = $request->file('driver_liscense_image')->store('image','public');
        $newcar['car_liscense_image'] = $request->file('car_liscense_image')->store('image','public');
        $newcar['car_insurance_image'] = $request->file('car_insurance_image')->store('image','public');
        $newcar['car_front_image'] = $request->file('car_front_image')->store('image','public');
        $newcar['car_back_image'] = $request->file('car_back_image')->store('image','public');
        $newcar = Car::create($newcar);
        return response()->json(['status'=>'success','message'=>'your car now registered']);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyphone(DriverVerifyAccountRequest $request){
        $otp=$request->validated();
        $user_data=Driver::where('otp_code',$otp);
        if($user_data->exists()){
            $user_data->update(['verify'=>'verified']);
            return response()->json(['status'=>'success','message'=>'your account is now verified']);
        }else{
            return response()->json(['status'=>'fail','message'=>'your code is not valied']);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function driverLogin(DrivrLoginRequest $request){
        $data = $request->validated();

        if($token =auth()->guard('driver')->attempt($data)){
            return response()->json(['status'=>'success','token'=>$token]);
        }else{
            return response()->json(['status'=>'failed','message'=>'access denied']);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->guard('driver')->logout();

        return response()->json(['status'=>'success','message'=>'you are loged out']);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotRequest $request){
        $user_data = $request->validated();
        $user = Driver::where('phone',$user_data)->first();
        // $user1->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','message'=>'an otp number sent to your phone number']);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetPassCodeRequest $request){
        $data = $request->validated();
        $user = Driver::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['status'=>'success','message'=>'code is valied']);
        }else{
            return response()->json(['status'=>'fail','message'=>'code is valied']);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){
        $data = $request->validated();
        $user = Driver::where('phone',$request->phone)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();

        return response()->json(['status'=>'success','message'=>'your passowrd is now changed successfully']);
    }


    /*--------------------------------------------------------------------------------------*/
        //to get personal info

    public function driverinfo(){
        $user_info= Driver::where('id', auth()->id())->get();
        // $info=InfoResource::collection($user_info);
        return response()->json(['status'=>'success','message'=>'your personal info','data'=>$user_info]);
    }


    /*------------------------------------------------------------------------------------*/
        //to update personal info

    public function updateinfo(DriverUpdateinfoRequest $request){
        $data= $request->validated();
        $newinfo=Driver::where('id', auth()->id());
        $newinfo->update([
                    'image'=> $request->file('image')->store('image','public'),
                    'phone'=>$request->phone,
                    'driver_name'=>$request->driver_name,
                    'city'=>$request->city,
                    'address'=>$request->address,
                    'email'=>$request->email]);
        return response()->json(['status'=>'success',"message"=>'your personal info updated']);
    }


    /*---------------------------------------------------------------------------------------*/


        public function updateCar(CarUpdateRequest $request){
            $data= $request->validated();
            $update_car = Car::where('driver_id',auth()->id())->first();
            $update_car->update([
                'driver_liscense_image'=> $request->file('driver_liscense_image')->store('image','public'),
                'car_liscense_image'=> $request->file('car_liscense_image')->store('image','public'),
                'car_insurance_image'=> $request->file('car_insurance_image')->store('image','public'),
                'car_front_image'=> $request->file('car_front_image')->store('image','public'),
                'car_back_image'=> $request->file('car_back_image')->store('image','public')
            ]);
            return response()->json(['status'=>'success',"message"=>'your car info updated']);
        }
    /*---------------------------------------------------------------------------------------*/

    public function notification(){
        $user = auth()->user();
        $not = $user->notifications;
        $noty = NotificationResource::collection($not);
        return response()->json(['status'=>'success','data'=>$noty]);
    }
}


