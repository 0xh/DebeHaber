<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaxpayerCurrency extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('taxpayer_settings', function (Blueprint $table) {
            $table->string('currency', 3)->default('PYG')->nullable()->after('type');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('taxpayer_settings', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
}
