<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');

            $table->unsignedInteger('chart_accounts_id');
            $table->foreign('chart_accounts_id')->references('id')->on('chart_accounts')->onDelete('cascade');

            $table->unsignedInteger('chart_vats_id');
            $table->foreign('chart_vats_id')->references('id')->on('chart_accounts')->onDelete('cascade');

            $table->unsignedDecimal('value', 18, 2);

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
        Schema::dropIfExists('transaction_details');
    }
}
