<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxpayerIntegrationsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('taxpayer_integrations', function (Blueprint $table)
        {
            $table->unsignedInteger('taxpayer_id');
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->unsignedInteger('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

            $table->unsignedTinyInteger('type')->comment('1 = Company. 2 = Accountant. 3 = Auditor');
            $table->boolean('is_owner')->default(false);

            $table->string('agent_name', 64)->nullable();
            $table->string('agent_taxid', 32)->nullable();
            $table->boolean('is_company')->default(false);

            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('taxpayer_integrations');
    }
}
