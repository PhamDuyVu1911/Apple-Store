<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'path_name'=>$this->path_name,
            'title'=>$this->title,
            'product_id'=>$this->product_id
        ];
    }
}
