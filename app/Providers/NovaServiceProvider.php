<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        parent::boot();
    }

    /**
    * Register the Nova routes.
    *
    * @return void
    */
    protected function routes()
    {
        Nova::routes()
        ->withAuthenticationRoutes()
        ->withPasswordResetRoutes()
        ->register();
    }

    /**
    * Register the Nova gate.
    *
    * This gate determines who can access Nova in non-local environments.
    *
    * @return void
    */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'ashah@indopar.com.py',
                'abhi@cognitivo.in',
                'pankeel@cognitivo.in',
            ]);
        });
    }

    /**
    * Get the cards that should be displayed on the Nova dashboard.
    *
    * @return array
    */
    protected function cards()
    {
        return [
            // new Help,
            new \Nickfairchild\AtAGlance\AtAGlance,
            new \Wilburpowery\RoutesCached\RoutesCached,
        ];
    }

    /**
    * Get the tools that should be listed in the Nova sidebar.
    *
    * @return array
    */
    public function tools()
    {
        return [
            new \Beyondcode\TinkerTool\Tinker(),
            new \Davidpiesse\NovaMaintenanceMode\Tool(),
        ];
    }

    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        //
    }
}
