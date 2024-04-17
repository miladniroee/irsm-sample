<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'description',
        'amount',
        'type',
        'usage_count',
        'usage_limit',
        'usage_limit_per_user',
        'expires_at',
        'free_shipping',
        'is_active',
        'exclude_sale_items',
        'minimum_amount',
        'maximum_amount',
        'maximum_discount_amount',
        'products',
        'product_categories',
        'product_brands',
        'seller_ids',
        'user_ids',
    ];

    protected $casts = [
        'products' => 'array',
        'product_categories' => 'array',
        'product_brands' => 'array',
        'seller_ids' => 'array',
        'user_ids' => 'array',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'free_shipping' => 'boolean',
        'exclude_sale_items' => 'boolean',
        'usage_limit' => 'integer',
        'usage_limit_per_user' => 'integer',
        'usage_count' => 'integer',
        'amount' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_amount' => 'decimal:2',
        'maximum_discount_amount' => 'decimal:2',
    ];


    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'coupon_id');
    }

    public function isExpired(): bool
    {
        if ($this->expires_at):
            return Carbon::now()->greaterThan($this->expires_at);
        endif;

        return false;
    }

    public function isUsed(): bool
    {
        if ($this->usage_limit):
            return $this->usage_limit <= $this->usage_count;
        endif;

        return false;
    }

    public function isUsedByUser(?User $user): bool
    {

        if ($this->usage_limit_per_user && $user):
            $usedByUser = $user->orders()->where('coupon_id', $this->id)->count();
            return $this->usage_limit_per_user <= $usedByUser;
        endif;

        return false;
    }

    public function isNotActive(): bool
    {
        return !$this->is_active;
    }

    public function isGreaterThanMaximum($cartTotal): bool
    {
        if ($this->maximum_amount):
            return $cartTotal > $this->maximum_amount;
        endif;

        return false;
    }

    public function isLessThanMinimum($cartTotal): bool
    {
        if ($this->minimum_amount):
            return $cartTotal < $this->minimum_amount;
        endif;

        return false;
    }

    public function isExcludedSaleItems(): bool
    {
        return $this->exclude_sale_items;
    }

    public function isFreeShipping(): bool
    {
        return $this->free_shipping;
    }




    public function isForProduct($productId): bool
    {
        if ($this->productLimited()):
            return in_array($productId, $this->products);
        endif;

        return true;
    }

    public function isForCategory($category): bool
    {
        if ($this->categoryLimited()):
            return in_array($category->id, $this->product_categories);
        endif;

        return true;
    }

    public function isForBrand($brand): bool
    {
        if ($this->brandLimited()):
            return in_array($brand, $this->product_brands);
        endif;

        return true;
    }

    public function isForSeller($seller): bool
    {
        if ($this->sellerLimited()):
            return in_array($seller, $this->seller_ids);
        endif;

        return true;
    }

    public function isForUser($user): bool
    {
        if ($this->userLimited()):
            return in_array($user->id, $this->user_ids);
        endif;

        return true;
    }


    public function productLimited(): bool
    {
        return !empty($this->products);
    }

    public function categoryLimited(): bool
    {
        return !empty($this->product_categories);
    }

    public function brandLimited(): bool
    {
        return !empty($this->product_brands);
    }

    public function sellerLimited(): bool
    {
        return !empty($this->seller_ids);
    }

    public function userLimited(): bool
    {
        return !empty($this->user_ids);
    }


    public function hasNoProduct($productIds): bool
    {
        if ($this->productLimited()):
            return count(array_intersect($productIds, $this->products)) == 0;
        endif;

        return false;
    }

    public function hasNoCategory($categoryIds): bool
    {
        if ($this->categoryLimited()):
            return count(array_intersect($categoryIds, $this->product_categories)) == 0;
        endif;

        return false;
    }

    public function hasNoBrand($brandIds): bool
    {
        if ($this->brandLimited()):
            return count(array_intersect($brandIds, $this->product_brands)) == 0;
        endif;

        return false;
    }

    public function hasNoSeller($sellerIds): bool
    {
        if ($this->sellerLimited()):
            return count(array_intersect($sellerIds, $this->seller_ids)) == 0;
        endif;

        return false;
    }

}
