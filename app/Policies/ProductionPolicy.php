<?php

namespace App\Policies;

use App\User;
use App\Production;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the production.
     *
     * @param  \App\User  $user
     * @param  \App\Production  $production
     * @return mixed
     */
    public function view(User $user, Production $production)
    {
        //
    }

    /**
     * Determine whether the user can create productions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the production.
     *
     * @param  \App\User  $user
     * @param  \App\Production  $production
     * @return mixed
     */
    public function update(User $user, Production $production)
    {
        //
    }

    /**
     * Determine whether the user can delete the production.
     *
     * @param  \App\User  $user
     * @param  \App\Production  $production
     * @return mixed
     */
    public function delete(User $user, Production $production)
    {
        //
    }
}
