<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name_receive'=>$this->name_receive,
            'phone_receive'=>$this->phone_receive,
            'address_receive'=>$this->address_receive,
            'note'=>$this->note,
            'total_money'=>$this->total_money,
            'status_order'=>$this->status_order,
            'user_id'=>$this->user_id,
        ];
    }
}
