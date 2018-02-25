<?php

namespace App\Policies;

use App\User;
use App\Inventory;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the inventory.
     *
     * @param  \App\User  $user
     * @param  \App\Inventory  $inventory
     * @return mixed
     */
    public function view(User $user, Inventory $inventory)
    {
        //
    }

    /**
     * Determine whether the user can create inventories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the inventory.
     *
     * @param  \App\User  $user
     * @param  \App\Inventory  $inventory
     * @return mixed
     */
    public function update(User $user, Inventory $inventory)
    {
        //
    }

    /**
     * Determine whether the user can delete the inventory.
     *
     * @param  \App\User  $user
     * @param  \App\Inventory  $inventory
     * @return mixed
     */
    public function delete(User $user, Inventory $inventory)
    {
        //
    }
}
