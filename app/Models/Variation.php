<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'variation_type_id',
        'name',
        'slug',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VariationType::class,'variation_type_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class, 'product_attributes', 'variation_id', 'product_variation_id');
    }

}
