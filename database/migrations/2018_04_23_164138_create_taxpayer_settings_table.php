<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxpayerSettingsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('taxpayer_settings', function (Blueprint $table)
        {
            $table->unsignedInteger('taxpayer_id');
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->unsignedTinyInteger('type')->nullable();
            $table->unsignedTinyInteger('regime_type')->nullable();
            $table->string('agent_name', 64)->nullable();
            $table->string('agent_taxid', 32)->nullable();
            $table->boolean('show_inventory')->default(false);
            $table->boolean('show_production')->default(false);
            $table->boolean('show_fixedasset')->default(false);

            $table->boolean('does_import')->default(false);
            $table->boolean('does_export')->default(false);

            $table->boolean('is_company')->default(false);
        });

        Schema::table('taxpayer_integrations', function (Blueprint $table)
        {
            $table->dropColumn(['agent_name', 'agent_taxid', 'is_company']);
        });

        Schema::table('taxpayers', function (Blueprint $table)
        {
            $table->dropColumn('regime_type');
        });

        Schema::table('transaction_details', function (Blueprint $table)
        {
            $table->unsignedDecimal('cost', 18, 2)
            ->default(0)->after('value');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('taxpayer_settings');

        Schema::table('taxpayer_integrations', function (Blueprint $table)
        {
            $table->string('agent_name', 64)->nullable();
            $table->string('agent_taxid', 32)->nullable();
            $table->boolean('is_company')->default(false);
        });

        Schema::table('taxpayers', function (Blueprint $table)
        {
            $table->unsignedTinyInteger('regime_type')->after('name')->nullable();
        });

        Schema::table('transaction_details', function (Blueprint $table)
        {
            $table->dropColumn('cost');
        });
    }
}
