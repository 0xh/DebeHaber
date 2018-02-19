<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::group(['middleware' => 'auth'], function ()
{
    Route::resource('/taxpayer', 'TaxpayerController');
    Route::resource('/chart-version', 'ChartVersionController');
    Route::resource('/cycle', 'CycleController');

    Route::prefix('/{taxPayer}/{cycle}')->group(function ()
    {
        Route::get('/dashboard', 'TaxpayerController@showDashboard')->name('taxpayer.dashboard');

        Route::prefix('/com')->group(function ()
        {
            Route::resources([
                'sales' => 'SalesController',
                'credit-notes' => 'TaxpayerController',
                'account-receivables' => 'AccountReceivableController',

                'purchases' => 'PurchaseController',
                'debit-notes' => 'DebitNoteController',
                'account-payable' => 'AccountPayableController'
            ]);
        });

        Route::prefix('/acc')->group(function ()
        {
            Route::resources([
                'journals' => 'JournalController',
                'journal-template' => 'JournalTemplateController',
                'journal-simulation' => 'JournalSimulationController'
            ]);
        });
    });
});

Route::get('/chartversion', 'ChartVersionController@index');

Route::post('/store_chartversion', 'ChartVersionController@store');
Route::get('/get_chartversion', 'ChartVersionController@get_chartversion');

Route::get('/cycle', 'CycleController@index')->name('cycle.index');

Route::post('/store_cycle', 'CycleController@store');
Route::get('/get_cycle', 'CycleController@get_cycle');


// Language
// debehaber.com/en/taxpayer
// Create Taxpayer

// Company
// debehaber.com/en/company-alias/fixed-asset
// Configuration Routes, FixedAssets, CurrencyRate, TaxpayerSettings

// Cycle
// debehaber.com/en/company-alias/2018/purchases
// All Commercial Routes
// All Accounting Routes
