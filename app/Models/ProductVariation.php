<?php

namespace App\Models;

use App\Enums\AttachmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'variations',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'in_stock',
        'featured',
        'sales',
        'barcode',
        'store_id',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'in_stock' => 'boolean',
        'stock_quantity' => 'integer',
        'featured' => 'boolean',
        'sales' => 'integer',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Variation::class, 'product_attributes', 'product_variation_id', 'variation_id');
    }


    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable')->where('type', AttachmentType::Image);
    }

    public function store(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function name(): string
    {
        $attributes = [];
        foreach ($this->attributes()->get() as $attribute) {
            $attributes[] = $attribute->type->name . ':' . $attribute->name;
        }
        if (empty($attributes)) return $this->product->name;

        return $this->product->name . ' - ' . implode(' | ', $attributes);
    }

}
