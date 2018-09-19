<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use Laravel\Spark\Exceptions\IneligibleForPlan;
use Laravel\Cashier\Cashier;

class SparkServiceProvider extends ServiceProvider
{
    /**
    * Your application and company details.
    *
    * @var array
    */
    protected $details = [
        'vendor' => 'Cognitivo Inc',
        'product' => 'DebeHaber',
        'street' => 'Planta Industrial, Km 24 Ruta II.',
        'location' => 'Capiata, Paraguay',
        'phone' => '+595-228-63115',
    ];

    /**
    * The address where customer support e-mails should be sent.
    *
    * @var string
    */
    protected $sendSupportEmailsTo = 'soporte@debehaber.com';

    /**
    * All of the application developer e-mail addresses.
    *
    * @var array
    */
    protected $developers = [
        'abhi@cognitivo.in',
        'ashah@indopar.com.py',
        'pankeel@cognitivo.in',
        'heti.shah@gmail.com'
    ];

    /**
    * Indicates if the application will expose an API.
    *
    * @var bool
    */
    protected $usesApi = true;

    /**
    * Finish configuring Spark for the application.
    *
    * @return void
    */
    public function booted()
    {
        Spark::useTwoFactorAuth();

        Spark::useStripe()->noCardUpFront()->teamTrialDays(15);

        Spark::useRoles([
            'mem' => 'Member',
            'aux' => 'Auxiliary',
            'acc' => 'Accountant',
            'aud' => 'Auditor',
        ]);

        Spark::noAdditionalTeams();

        Spark::chargeTeamsPerSeat('Contribuyente', function ($team) {
            return $team->taxpayers()->count();
        });

        // Cashier::useCurrency('pyg', 'PYG ');

        Spark::freeTeamPlan()
        ->maxTeamMembers(10)
        ->features([
            'All features, for one taxpayer.'
        ]);

        Spark::teamPlan('Pro', 'prod_DdObX1q0PigT2d')
        ->price(10)
        ->features([
            'All features, for each taxpayer.'
        ]);

        // Spark::promotion('coupon');

        Spark::checkPlanEligibilityUsing(function ($user, $plan)
        {
            if ($plan->name == 'Pro' && $user->todos->count() > 20)
            {
                throw IneligibleForPlan::because('You have too many to-dos.');
            }

            return true;
        });
    }
}
