<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'line_1',
        'line_2',
        'city',
        'country',
        'state',
        'post_code'
    ];
}
