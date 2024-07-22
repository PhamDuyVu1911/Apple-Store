<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'key'=>$this->key,
            'value'=>$this->value,
            'product_id'=>$this->product_id
        ];
    }
}
