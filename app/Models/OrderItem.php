<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;


    public $timestamps = false;


    protected $fillable = [
        'id',
        'sub_order_id',
        'variation_id',
        'coupon_id',
        'name',
        'type',
        'quantity',
        'price',
        'total',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function subOrder(): BelongsTo
    {
        return $this->belongsTo(SubOrder::class, 'sub_order_id');
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }
}
