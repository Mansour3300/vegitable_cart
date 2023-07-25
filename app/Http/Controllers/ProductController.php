<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\SortRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product=Product::paginate(10);
        $add=ProductResource::collection($product);
        return response()->json(['success'=>'true','products'=>$add]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request,$id)
    {
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $data['category_id']=$id;
        $add_product = Product::create($data);
        $add=ProductResource::make($add_product);
        return response()->json(['success'=>'true','message'=>'product added successfully','added'=>$add]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product1= Product::findorfail($id);
        $product1->images;
        return response()->json(['success'=>'true','your product images'=>$product1]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $updated= Product::findorfail($id)->update($data);
    return response()->json(['success'=>'true','message'=>'product updated',/*'update'=>$updated*/]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product0 = Product::findorfail($id)->image;
        $product1 = Product::findorfail($id);
        unlink(storage_path('app/public/'.$product0));
        $product1->delete();
        return response()->json(['success'=>'true','message'=>'product deleted']);
    }

    /**
     *
     */

     public function sortdesc(SortRequest $request)
     {
        $request->validated;
        $data = Product::all();
        $collection = collect($data);
                       $filter = $collection->sortDesc()
                    ->whereBetween('price_kilo',[$request->min,$request->max]);
                       $filter->all();
        return response()->json(['success'=>'true','your products'=>$filter]);
     }


}
