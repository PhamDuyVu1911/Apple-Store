<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'value',
        'product_id',
        'delete',
    ];

    // Một cấu hình chỉ thuộc duy nhất một sản phẩm
    public function product() {
        return $this->belongsTo(Product::class)->where('delete', false);
    }
}
