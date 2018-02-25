<?php

namespace App\Policies;

use App\User;
use App\FixedAsset;
use Illuminate\Auth\Access\HandlesAuthorization;

class FixedAssetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the fixedAsset.
     *
     * @param  \App\User  $user
     * @param  \App\FixedAsset  $fixedAsset
     * @return mixed
     */
    public function view(User $user, FixedAsset $fixedAsset)
    {
        //
    }

    /**
     * Determine whether the user can create fixedAssets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the fixedAsset.
     *
     * @param  \App\User  $user
     * @param  \App\FixedAsset  $fixedAsset
     * @return mixed
     */
    public function update(User $user, FixedAsset $fixedAsset)
    {
        //
    }

    /**
     * Determine whether the user can delete the fixedAsset.
     *
     * @param  \App\User  $user
     * @param  \App\FixedAsset  $fixedAsset
     * @return mixed
     */
    public function delete(User $user, FixedAsset $fixedAsset)
    {
        //
    }
}
