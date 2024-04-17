<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'author_name',
        'author_email',
        'author_url',
        'author_ip',
        'parent_id',
        'rating',
        'body',
        'is_approved',
    ];

    protected $casts = [
        'commentable_id' => 'integer',
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('approved', function ($query) {
            $query->where('is_approved', true);
        });
    }

    public function commentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function subChildren(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class,'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        if ($this->subChildren()->count() > 0) {
            return $this->subChildren()->with('children');
        } else {
            return $this->subChildren();
        }
    }

    public function scopePostComments($query)
    {
        return $query->where('commentable_type', Post::class);
    }

    public function scopeProductComments($query)
    {
        return $query->where('commentable_type', Product::class);
    }
}
