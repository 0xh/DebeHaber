<?php

namespace App\Policies;

use App\User;
use App\Chart;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChartPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the chart.
     *
     * @param  \App\User  $user
     * @param  \App\Chart  $chart
     * @return mixed
     */
    public function view(User $user, Chart $chart)
    {
        //
    }

    /**
     * Determine whether the user can create charts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the chart.
     *
     * @param  \App\User  $user
     * @param  \App\Chart  $chart
     * @return mixed
     */
    public function update(User $user, Chart $chart)
    {
        //
    }

    /**
     * Determine whether the user can delete the chart.
     *
     * @param  \App\User  $user
     * @param  \App\Chart  $chart
     * @return mixed
     */
    public function delete(User $user, Chart $chart)
    {
        //
    }
}
