<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        "total" => "float"
    ];

    protected $fillable = [
        'id',
        'payment_method',
        'shipping_method',
        'customer_id',
        'company_id',
        'type',
        'billing_address_id',
        'shipping_address_id',
        'total'
    ];
}
