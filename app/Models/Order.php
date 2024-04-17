<?php

namespace App\Models;

use App\Enums\OrderDetailType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'status',
        'total',
        'discount',
        'tax',
        'shipping',
        'net_total',
        'coupon_id',
        'completed_at',
    ];

    protected $casts = [
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'net_total' => 'decimal:2',
        'total' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function subOrders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubOrder::class, 'order_id');
    }

    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderNote::class, 'order_id');
    }

    public function orderDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderDetail::class, 'order_id');
    }
    public function shipping()
    {
        return $this->orderDetail()->where('type', OrderDetailType::Shipping)->first();
    }

    public function billing()
    {
        return $this->orderDetail()->where('type', OrderDetailType::Billing)->first();
    }

    public function coupon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderPayment::class, 'order_id')->with('method');
    }
}
