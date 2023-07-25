<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Requests\ProductImageRequest;
use App\Http\Resources\ProductImageResource;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product_image = ProductImage::paginate(10);
        $add=ProductImageResource::collection($product_image);
        return response()->json(['success'=>'true','images'=>$add]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductImageRequest $request,$id)
    {
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $data['product_id']=$id;
        $add_image = ProductImage::create($data);
        $add=ProductImageResource::make($add_image);
        return response()->json(['success'=>'true','message'=>'product image added successfully','added'=>$add]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_image1= ProductImage::findorfail($id);
        $add=ProductImageResource::make($product_image1);
        return response()->json(['success'=>'true','your product images'=>$add]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ProductImageRequest $request, string $id)
    {
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $updated= ProductImage::findorfail($id)->update($data);
    return response()->json(['success'=>'true','message'=>'product image updated'/*,'update'=>$updated*/]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product_image0 = ProductImage::findorfail($id)->image;
        $product_image1 = ProductImage::findorfail($id);
        unlink(storage_path('app/public/'.$product_image0));
        $product_image1->delete();
        return response()->json(['success'=>'true','message'=>'product image deleted']);
    }
}
