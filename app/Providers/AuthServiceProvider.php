<?php

namespace App\Providers;

use App\Policies\AccountMovementPoliciy;
use App\Policies\ChartPoliciy;
use App\Policies\CycleBudgetPoliciy;
use App\Policies\CyclePoliciy;
use App\Policies\DocumentPoliciy;
use App\Policies\FixedAssetPoliciy;
use App\Policies\ImpexPoliciy;
use App\Policies\InventoryPoliciy;
use App\Policies\JournalPoliciy;
use App\Policies\ProductionPoliciy;
use App\Policies\TransactionPoliciy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
    * The policy mappings for the application.
    *
    * @var array
    */
    protected $policies = [
        'App\Model'             => 'App\Policies\ModelPolicy',
        'App\AccountMovement'   => AccountMovementPoliciy::class,
        'App\Chart'             => ChartPoliciy::class,
        'App\CycleBudget'       => CycleBudgetPoliciy::class,
        'App\Cycle'             => CyclePoliciy::class,
        'App\Document'          => DocumentPoliciy::class,
        'App\FixedAsset'        => FixedAssetPoliciy::class,
        'App\Impex'             => ImpexPoliciy::class,
        'App\Inventory'         => InventoryPoliciy::class,
        'App\Journal'           => JournalPoliciy::class,
        'App\Production'        => ProductionPoliciy::class,
        'App\Transaction'       => TransactionPoliciy::class,
    ];

    /**
    * Register any authentication / authorization services.
    *
    * @return void
    */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::enableImplicitGrant();

        Passport::tokensCan([
            'Create' => 'Create Transactions',
            'Read' => 'Create Transactions',
        ]);
    }
}
