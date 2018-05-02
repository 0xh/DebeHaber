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
        Schema::table('charts', function (Blueprint $table)
        {
            $table->index(['type', 'sub_type']);
        });

        Schema::table('taxpayer_integrations', function (Blueprint $table)
        {
            $table->unsignedTinyInteger('status')->default(1)->after('is_owner')->comment('1 = Pending, 2 = Approved, 3 = Rejected, 4 = Archive');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        //No Changes
        Schema::table('taxpayer_integrations', function (Blueprint $table)
        {
            $table->dropColumn('status');
        });
    }
}
