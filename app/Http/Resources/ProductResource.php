<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'product_id'=>$this->id,
            'product name'=>$this->product_name,
            'price/kilo'=>$this->price_kilo,
            'discreption'=>$this->discreption,
            'image'=>asset('storage/'.$this->image),
            'discount'=>$this->discount,
            'product code'=>$this->product_code
            // 'image'=>ProductImageResource::collection($this->images),
        ];
    }
}
