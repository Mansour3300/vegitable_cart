<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'order_id'=>$this->id,
            'total_price'=>$this->total_price,
            'code'=>$this->order_code,
            'status'=>$this->status,
            'details'=>json_decode($this->details), //لاحظ هنا لاننا ماستخدمناش مودل
            'address'=>$this->address,
            'date'=>$this->delivery_date,
            'time'=>$this->delivery_time,
            'name'=>$this->user_name

        ];
    }
}
