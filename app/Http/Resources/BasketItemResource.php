<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\BasketProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data = Product::where('id',$this->product_id)->first();
        // dd($data);
        return[
            'product_id'=>$this->product_id,
            'count'=>$this->count,
            'price/kilo'=>$data->price_kilo,
            'product_name'=>$data->product_name,
            // 'image'=>$data->image
            'image'=>asset('storage/'.$data->image)

        ];
    }
}
