<?php

namespace App\Models;

use App\Enums\AttachmentType;
use App\Enums\ProductStatus;
use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const COLOR_VARIATION_TYPE_ID = 2;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'type',
        'excerpt',
        'description',
        'price',
        'sale_price',
        'featured',
        'in_stock',
        'stock_quantity',
        'view_count',
        'rating_count',
        'average_rating',
        'total_sales',
        'status',
        'brand_id',
        'user_id',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'featured' => 'boolean',
        'in_stock' => 'boolean',
        'stock_quantity' => 'integer',
        'view_count' => 'integer',
        'rating_count' => 'integer',
        'average_rating' => 'integer',
        'total_sales' => 'integer',
    ];

    protected static function booted()
    {
        static::addGlobalScope('published', function (Builder $builder){
           $builder->where('status',ProductStatus::Published);
        });
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function variations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')
            ->where('type', AttachmentType::Image)
            ->where('is_thumbnail', true);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable')
            ->where('type', AttachmentType::Image);
    }

    public function variationAttributes()
    {
        return $this->variations->pluck('attributes')->flatten()->unique('slug')->filter(function ($item){
            return $item->variation_type_id === self::COLOR_VARIATION_TYPE_ID;
        })->all();
    }
}

