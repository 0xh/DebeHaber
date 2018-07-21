<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CurrencyRateScope implements Scope
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
        //$taxPayer = request()->route('taxPayer');

        $builder->where('taxpayer_id', request()->route('taxPayer'))
        ->where('currency_id', request()->route('taxPayer'))
        ->orderBy('taxpayer_id');

        //Get Specific for current version.
        $builder->where(function($subQuery) use ($taxPayer, $cycle)
        {
            $subQuery->where('taxpayer_id', $taxPayer->id);
        })
        //Get Generic for Current Version
        ->orWhere(function($subQuery) use ($taxPayer, $cycle)
        {
            $subQuery->whereNull('taxpayer_id')
            ->where('currency_id', request()->route('currency_id'));
        });
    }
}
