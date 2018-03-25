<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MissingFields extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        //Company or Integration Fields
        Schema::table('taxpayers', function (Blueprint $table)
        {
            $table->unsignedTinyInteger('regime_type')->after('name')->nullable();
        });

        //User Fields
        Schema::table('users', function (Blueprint $table)
        {
            $table->string('country', 3)->default('PRY')->after('photo_url');
            $table->string('language', 5)->default('es')->after('country');
            $table->string('timezone', 32)->default('America/La_Paz')->after('language');
        });

        //Currency Rate Fields
        //buy and sell rates.
        //also date field.

        Schema::table('currency_rates', function (Blueprint $table)
        {
            $table->dropColumn('rate');

            $table->unsignedInteger('taxpayer_id')->nullable()->after('currency_id');
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->date('date')->after('taxpayer_id');
            $table->decimal('buy_rate', 10, 4)->default(1)->after('date');
            $table->decimal('sell_rate', 10, 4)->default(1)->after('buy_rate');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        //
    }
}
