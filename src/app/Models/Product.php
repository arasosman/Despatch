<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        "price" => "float",
        "sku" => "integer"
    ];

    protected $fillable = [
        "title",
        "description",
        "image",
        "sku",
        "price"
    ];
}
