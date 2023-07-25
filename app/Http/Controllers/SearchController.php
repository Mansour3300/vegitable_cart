<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($term){
            $result = Product::where('product_name', 'like','%'.$term. '%')->get();
            if(count($result)){
            return response()->json(['status'=>'true','message'=>'search result','result'=>$result]);
    }
    return response()->json(['success'=>'fail','message'=>'no such product exists']);
}
}
