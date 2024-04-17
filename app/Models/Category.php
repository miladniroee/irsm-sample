<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    const NO_CATEGORY_SHOP = 1;
    const NO_CATEGORY_BLOG = 2;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'parent_id',
        'description',
        'image',
        'type',
        'code',
        'posts_count',
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subChildren(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        if ($this->subChildren()->count() > 0) {
            return $this->subChildren()->with('children');
        } else {
            return $this->subChildren();
        }
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'category_posts');
    }

    public function scopeBlog($query)
    {
        return $query->where('type', CategoryType::Post);
    }

    public function scopeShop($query)
    {
        return $query->where('type', CategoryType::Product);
    }
}
