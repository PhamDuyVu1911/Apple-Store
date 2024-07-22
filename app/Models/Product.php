<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'price',
        'sale_price',
        'hot',
        'view_count',
        'brand',
        'img',
        'color',
        'category_id',
        'delete',
    ];

    // Một sản phẩm chỉ thuộc duy nhất một danh mục
    public function category() {
        return $this->belongsTo(Category::class)->where('delete', false);
    }

    // Một sản phẩn có thể có một hoặc nhiều chi tiết hoá đơn
    public function orderDetails() {
        return $this->hasMany(OrderDetail::class)->where('delete', false);
    }

    // Một sản phẩn có thể có một hoặc nhiều hình ảnh
    public function images() {
        return $this->hasMany(Image::class)->where('delete', false);
    }

    // Một sản phẩn có thể có một hoặc cấu hình
    public function specifications() {
        return $this->hasMany(Specification::class)->where('delete', false);
    }
}
