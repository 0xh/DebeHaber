<?php

namespace App\Policies;

use App\User;
use App\CycleBudget;
use Illuminate\Auth\Access\HandlesAuthorization;

class CycleBudgetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the cycleBudget.
     *
     * @param  \App\User  $user
     * @param  \App\CycleBudget  $cycleBudget
     * @return mixed
     */
    public function view(User $user, CycleBudget $cycleBudget)
    {
        //
    }

    /**
     * Determine whether the user can create cycleBudgets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the cycleBudget.
     *
     * @param  \App\User  $user
     * @param  \App\CycleBudget  $cycleBudget
     * @return mixed
     */
    public function update(User $user, CycleBudget $cycleBudget)
    {
        //
    }

    /**
     * Determine whether the user can delete the cycleBudget.
     *
     * @param  \App\User  $user
     * @param  \App\CycleBudget  $cycleBudget
     * @return mixed
     */
    public function delete(User $user, CycleBudget $cycleBudget)
    {
        //
    }
}
