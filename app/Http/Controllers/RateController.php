<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use App\Http\Requests\RateRequest;
use App\Http\Resources\RateResource;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $rate = Rate::where('product_id',$id)->get();
        $data = RateResource::collection($rate);
        return response()->json(['success'=>'true','all comments on product'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RateRequest $request)
    {
        $valied = $request->validated();
        $valied['id'] = auth()->id();
        $rate = Rate::create($valied);
        $data = RateResource::make($rate);
        return response()->json(['success'=>'true','your comment on product '=>$data]);

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
    public function update(RateRequest $request, string $id)
    {
        $valied = $request->validated();
        $rate = Rate::where(['id'=>auth()->id(),'product_id'=>$id])->first();
        $rate->update($valied);
        $data = RateResource::make($rate);
        return response()->json(['success'=>'true','your comment on product '=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rate = Rate::where(['id'=>auth()->id(),'product_id'=>$id])->first()->delete();
        return response()->json(['success'=>'true','message'=>'your comment is deleted ']);
    }
}
