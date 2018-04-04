<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JournalScope implements Scope
{
    /**
    * Global Scope that works as follows:
    * Bring all Charts from Taxpayer, or where Taxpayer is null and country is same as taxpayer.
    * This will allow to bring charts that are generic but only form same country.
    *
    * Problem: This will not bring from current Cycle Version. Include that into Logic.
    *
    * @param  \Illuminate\Database\Eloquent\Builder  $builder
    * @param  \Illuminate\Database\Eloquent\Model  $model
    * @return void
    */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('cycle_id', request()->route('cycle')->id);
    }
}
