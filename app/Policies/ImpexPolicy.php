<?php

namespace App\Policies;

use App\User;
use App\Impex;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImpexPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the impex.
     *
     * @param  \App\User  $user
     * @param  \App\Impex  $impex
     * @return mixed
     */
    public function view(User $user, Impex $impex)
    {
        //
    }

    /**
     * Determine whether the user can create impexes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the impex.
     *
     * @param  \App\User  $user
     * @param  \App\Impex  $impex
     * @return mixed
     */
    public function update(User $user, Impex $impex)
    {
        //
    }

    /**
     * Determine whether the user can delete the impex.
     *
     * @param  \App\User  $user
     * @param  \App\Impex  $impex
     * @return mixed
     */
    public function delete(User $user, Impex $impex)
    {
        //
    }
}
