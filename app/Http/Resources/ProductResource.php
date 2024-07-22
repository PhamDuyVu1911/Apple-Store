<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'content'=>$this->content,
            'price'=>$this->price,
            'sale_price'=>$this->sale_price,
            'hot'=>$this->hot,
            'brand'=>'Apple',
            'img'=>$this->img,
            'color'=>$this->color,
            'category_id'=>$this->category_id,
        ];
    }
}
