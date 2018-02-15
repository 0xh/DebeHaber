<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('production_id');
            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');

            $table->unsignedInteger('input_id');
            $table->foreign('input_id')->references('id')->on('chart_accounts')->onDelete('cascade');

            $table->unsignedInteger('output_id');
            $table->foreign('output_id')->references('id')->on('chart_accounts')->onDelete('cascade');

            $table->unsignedDecimal('value', 18, 2);

            $table->string('comment')->nullable();

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
        Schema::dropIfExists('production_details');
    }
}
