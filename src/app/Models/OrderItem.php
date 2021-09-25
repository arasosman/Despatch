<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $casts = [
        'order_id' => 'integer',
        'product_id' => 'integer',
        'quantity' => 'integer',
        'subtotal' => 'float',
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'subtotal'
    ];
}
