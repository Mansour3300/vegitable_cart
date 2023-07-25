<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $country= Country::all();
        return response()->json(['success'=>'true','key'=>$country]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
        $new_country = $request->validated();
        $new_country['image']= $request->file('image')->store('image','public');
        $data = Country::create($new_country);

        return response()->json(['success'=>'true','data'=>$data]);
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
    public function update(CountryRequest $request, string $id)
    {
        $data = $request->validated();
        $data['image']= $request->file('image')->store('image','public');
        $new= Country::findorfail($id)->update($data);
    return response()->json(['success'=>'true','message'=>'country updated'/*,'new'=>$new*/]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::findorfail($id)->image;
        $country1 = Country::findorfail($id);
        unlink(storage_path('app/public/'.$country));
        $country1->delete();
        return response()->json(['success'=>'true','message'=>'country deleted']);
    }
}
