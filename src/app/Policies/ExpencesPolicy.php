<?php

namespace App\Policies;

use App\Models\Expences;
use App\Models\House;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Expences $expences): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, House $house): bool
    {
        return $house->isMembre($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expences $expences): bool
    {
        return $expences->house->userIsOwner($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expences $expences): bool
    {
        return $expences->house->userIsOwner($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Expences $expences): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Expences $expences): bool
    {
        return false;
    }
}
