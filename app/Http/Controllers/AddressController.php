<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $address = Address::where('user_id',auth()->id())->get();
        $data = AddressResource::collection($address);
        return response()->json(['success'=>'true','your address new'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $data =$request->validated();
        $data['user_id'] = auth()->id();
        $new = Address::create($data);
        $data = AddressResource::make($new);
        return response()->json(['success'=>'true','message'=>'you added new address',$data]);
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
        Address::findorfail($id)->delete();
        return response()->json(['success'=>'true','message'=>'you deleted your address']);
    }
}
