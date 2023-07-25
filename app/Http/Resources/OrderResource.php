<?php

namespace App\Http\Resources;

use App\Models\Basket;
use Illuminate\Http\Request;
use App\Http\Controllers\PriceController;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // $basket = Basket::where('user_id',auth()->id())->first();
        return [
            'total_price'=>$this->total_price,
            'code'=>$this->order_code,
            'status'=>$this->status,
            'details'=>$this->details,
            // 'address'=>$this->address,
            // 'date'=>$this->delivery_date,
            // 'time'=>$this->delivery_time

        ];
    }
}
