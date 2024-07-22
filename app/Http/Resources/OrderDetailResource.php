<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_id'=>$this->product_id,
            'order_id'=>$this->order_id,
            'quantity'=>$this->quantity,
            'price'=>$this->price,
        ];
    }
}
