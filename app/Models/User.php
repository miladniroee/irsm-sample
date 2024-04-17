<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\RoleType;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'email_verified_at',
        'phone_verified_at',
        'password',
        'password_reset_token',
        'otp',
        'otp_expire',
        'money_spent',
        'orders_count',
    ];

    protected $hidden = [
        'password',
        'otp',
        'otp_expire',
        'password_reset_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'money_spent' => 'decimal:2',
        'orders_count' => 'integer',
    ];


    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

//    public function getCartItemsAttribute()
//    {
//        return $this->cartItems->map(function ($cartItem) {
//            $cartItem->total = $cartItem->total();
//            return $cartItem;
//        });
//    }

    public function getCartItemsWithTotalsAttribute()
    {
        // Access the cartItems relationship
        return $this->cartItems->map(function ($cartItem) {
            // Call the total method on each cartItem and store the result in a new property
            $cartItem->total = $cartItem->total();
            return $cartItem;
        });
    }


    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'customer_id');
    }



}
