<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaxpayerSettingUpdate extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('taxpayer_settings', function (Blueprint $table)
        {
            // $table->increments('id');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('taxpayer_settings', function (Blueprint $table)
        {
            // $table->dropColumn(['id']);
        });
    }
}
