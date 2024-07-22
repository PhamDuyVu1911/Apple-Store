<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_receive',
        'phone_receive',
        'address_receive',
        'note',
        'total_money',
        'status_order',
        'user_id',
        'delete',
    ];

    // Một order chỉ thuộc một user duy nhất
    public function user() {
        return $this->belongsTo(User::class)->where('delete', false);
    }


     // Một hoá đơn có thể có một hoặc nhiều chi tiết hoá đơn
     public function orderDetails() {
        return $this->hasMany(OrderDetail::class)->where('delete', false);
    }
}
