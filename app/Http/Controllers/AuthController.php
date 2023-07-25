<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\InfoResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetCodeRequest;
use App\Http\Requests\ResetPassRequest;
use App\Http\Requests\ForgotpassRequest;
use App\Http\Requests\UpdateinfoRequest;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\VerifyPhoneRequest;
use App\Http\Requests\RegisterationRequest;
use App\Http\Resources\NotificationResource;
// use App\Notifications\ForgotPassOtpNotification;


class AuthController extends Controller
{

    public function register(RegisterationRequest $request){
        $newuser= $request->validated();
        $newuser['password']=Hash::make($newuser['password']);
        $newuser['image']= $request->file('image')->store('image','public');
        $newuser['otp_code']=rand(0000,9999);
        $user=User::create($newuser);
            return response()->json(['status'=>'success','message'=>'yor are now registered']);

}
/*------------------------------------------------------------------------------------------*/
    //this function verify account


    public function verifyphone(VerifyPhoneRequest $request){
        $otp=$request->validated();
        $user_data=User::where('otp_code',$otp);
        if($user_data->exists()){
            $user_data->update(['verify'=>'verified']);
            return response()->json(['success'=>'true','message'=>'your account is now verified']);
        }else{
            return response()->json(['success'=>'false','message'=>'your code is not valied']);
        }
    }

/*----------------------------------------------------------------------------------------*/


public function login(LoginRequest $request){
        $data=$request->validated();

        if($token =auth()->attempt($data)){
            return response()->json(['status'=>'success','token'=>$token]);
        }else{
            return response()->json(['status'=>'failed','message'=>'access denied']);
            }
}
/*------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->logout();

        return response()->json(['status'=>'success','message'=>'you are loged out']);
    }
/*------------------------------------------------------------------------------------------*/

    public function forgot(ForgotpassRequest $request){
        $user_data = $request->validated();
        $user1 = User::where('phone',$user_data)->first();
        // $user1->notify(new ForgotPassOtpNotification());
        return response()->json(['status'=>'success','message'=>'an otp number sent to your phone number']);
    }

    /*----------------------------------------------------------------------------------------*/
        //code to reset password

    public function resetcode(ResetCodeRequest $request){
        $data = $request->validated();
        $user = User::where(['otp_code'=>$request->otp_code,
                             'phone'=>$request->phone])->first();
        if($user->exists()){
            return response()->json(['success'=>'true','message'=>'code is valied']);
        }else{
            return response()->json(['success'=>'true','message'=>'code is valied']);
        }
    }
    /*---------------------------------------------------------------------------------------*/
        //to reset password

    public function resetpass(ResetPassRequest $request){
        $data = $request->validated();
        $user = User::where('phone',$request->phone)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();

        return response()->json(['success'=>'true','message'=>'your passowrd is now changed successfully']);
    }


    /*--------------------------------------------------------------------------------------*/
        //to get personal info

    public function personalinfo(){
        $user_info= User::where('id', auth()->id())->get();
        $info=InfoResource::collection($user_info);
        return response()->json(['success'=>"true","message"=>'your personal info','info'=>$info]);
    }


    /*------------------------------------------------------------------------------------*/
        //to update personal info

    public function updateinfo(UpdateinfoRequest $request){
        $data= $request->validated();
        $newinfo=User::where('id', auth()->id());
        $newinfo->update([
                    'image'=> $request->file('image')->store('image','public'),
                    'user_name'=>$request->user_name,
                    'city'=>$request->city ]);
        return response()->json(['success'=>"true","message"=>'your personal info updated']);
    }


    /*---------------------------------------------------------------------------------------*/

    public function notification(){
        $user = auth()->user();
        $not = $user->notifications;
        $noty = NotificationResource::collection($not);
        return response()->json(['success'=>'true','all notifications'=>$noty]);
    }
}


