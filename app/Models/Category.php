<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'delete',
    ];

    // Một danh mục có  thể có một hoặc nhiều sản phẩm
    public function products() {
        return $this->hasMany(Product::class)->where('delete', false);
    }
}
