<?php

namespace App\Policies;

use App\User;
use App\AccountMovement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountMovementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the accountMovement.
     *
     * @param  \App\User  $user
     * @param  \App\AccountMovement  $accountMovement
     * @return mixed
     */
    public function view(User $user, AccountMovement $accountMovement)
    {
        //
    }

    /**
     * Determine whether the user can create accountMovements.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the accountMovement.
     *
     * @param  \App\User  $user
     * @param  \App\AccountMovement  $accountMovement
     * @return mixed
     */
    public function update(User $user, AccountMovement $accountMovement)
    {
        //
    }

    /**
     * Determine whether the user can delete the accountMovement.
     *
     * @param  \App\User  $user
     * @param  \App\AccountMovement  $accountMovement
     * @return mixed
     */
    public function delete(User $user, AccountMovement $accountMovement)
    {
        //
    }
}
