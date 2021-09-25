<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $line_1
 * @property string $line_2
 * @property string $city
 * @property string $country
 * @property string $state
 * @property string $post_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @mixin Eloquent
 */
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
