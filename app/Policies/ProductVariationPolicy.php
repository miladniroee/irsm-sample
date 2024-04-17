<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\ProductVariation;
use App\Models\User;

class ProductVariationPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create variation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductVariation $ProductVariation): bool
    {
        if (!$user->hasPermissionTo('edit variation')){
            return false;
        }

        return $user->hasRole(RoleType::Admin->value) || $user->store->id === $ProductVariation->store_id;
    }

}
