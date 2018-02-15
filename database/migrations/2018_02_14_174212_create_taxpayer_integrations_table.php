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
            $table->integer('taxpayer_id')->unsigned();
            $table->string('agent_name')->nullable();
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
