<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category=Category::all();
        $data=CategoryResource::collection($category);
        // return CategoryResource::collection($category)->addition([]);
        return response()->json(['success'=>'true','data'=>$data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $add_category = Category::create($data);
        $add_category1=CategoryResource::make($add_category);
        return response()->json(['success'=>'true','message'=>'category added successfully','data'=>$add_category1]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category1= Category::with('products')->findorfail($id);
        $category1->products;
        return response()->json(['success'=>'true','data'=>$category1]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findorfail($id);
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $updated= $category->update($data);

    return response()->json(['success'=>'true','message'=>'category updated'/*,'update'=>$updated*/]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findorfail($id);
        // $category1 = Category::findorfail($id);
        unlink(storage_path('app/public/'.$category->image));
        $category->delete();
        return response()->json(['success'=>'true','message'=>'category deleted']);
    }
}
