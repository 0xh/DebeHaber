<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class TaxpayerIntegration extends Resource
{
    /**
    * The model the resource corresponds to.
    *
    * @var string
    */
    public static $model = 'App\TaxpayerIntegration';

    /**
    * The single value that should be used to represent the resource when being displayed.
    *
    * @var string
    */
    public static $title = 'taxpayer';

    /**
    * The columns that should be searched.
    *
    * @var array
    */
    public static $search = [
        'id',
    ];

    /**
    * Get the fields displayed by the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Taxpayer')->searchable(),
            BelongsTo::make('Team')->searchable(),

            Select::make('Type')->options([
                '1' => 'Company',
                '2' => 'Accountant',
                '3' => 'Auditor',
            ])->displayUsingLabels(),

            Select::make('Status')->options([
                '1' => 'Pending',
                '2' => 'Approved',
                '3' => 'Rejected',
            ])->displayUsingLabels(),
        ];
    }

    /**
    * Get the cards available for the request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function cards(Request $request)
    {
        return [];
    }

    /**
    * Get the filters available for the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function filters(Request $request)
    {
        return [];
    }

    /**
    * Get the lenses available for the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
    * Get the actions available for the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function actions(Request $request)
    {
        return [];
    }
}
