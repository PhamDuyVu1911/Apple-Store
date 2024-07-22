<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price',
    ];

    protected $primaryKey = ['product_id', 'order_id'];

    public $incrementing = false;

    // Một chi tiết hoá đơn chỉ thuộc một sản phẩm duy nhất
    public function product() {
        return $this->belongsTo(Product::class)->where('delete', false);
    }

     // Một chi tiết hoá đơn chỉ thuộc một hoá đơn duy nhất
     public function order() {
        return $this->belongsTo(Order::class)->where('delete', false);
    }
}
