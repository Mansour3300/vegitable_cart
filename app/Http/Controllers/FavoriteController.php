<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Resources\FavoritResource;
use App\Http\Resources\ProductResource;



class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Favorite::where('user_id',auth()->id())->get();
        $data = FavoritResource::collection($all);
        return response()->json(['sucess'=>'true','favorites'=>$data]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $basket = Product::where('id',$request->product_id)->get();
            // dd($basket);
            $valied['product'] =ProductResource::collection($basket);
            $valied['user_id'] = auth()->id();
            $valied['id'] = $request->product_id;
            $order = Favorite::create($valied);
            $data = FavoritResource::make($order);
            return response()->json(['sucess'=>'true','added to favorite'=>$data]);
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
        Favorite::findorfail($id)->delete();
        return response()->json(['success'=>'true','message'=>'deleted from favorites']);
    }
}
