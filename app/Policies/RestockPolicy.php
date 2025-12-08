<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Restock;

class RestockPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restock $restock): bool
    {
        // User must have access to the inventory this restock belongs to
        return $user->inventories->contains($restock->inventory_id) ||
               $user->id === $restock->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restock $restock): bool
    {
        // Only the creator or an admin can update
        return $user->id === $restock->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restock $restock): bool
    {
        // Only the creator can delete non-fulfilled plans
        return $user->id === $restock->user_id && !$restock->isFulfilled();
    }

    /**
     * Determine whether the user can fulfill the model.
     */
    public function fulfill(User $user, Restock $restock): bool
    {
        // User must have access to the inventory
        return $user->inventories->contains($restock->inventory_id) && !$restock->isFulfilled();
    }
}
