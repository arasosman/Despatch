<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $payment_method
 * @property string $shipping_method
 * @property int $customer_id
 * @property int $company_id
 * @property string $type
 * @property int $billing_address_id
 * @property int $shipping_address_id
 * @property float $total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Address $billingAddress
 * @property-read Company $company
 * @property-read Customer $customer
 * @property-read Collection|OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property-read Address $shippingAddress
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $casts = [
        "total" => "float"
    ];

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'payment_method',
        'shipping_method',
        'customer_id',
        'company_id',
        'type',
        'billing_address_id',
        'shipping_address_id',
        'total'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
