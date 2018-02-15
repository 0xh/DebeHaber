<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartAccountsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('chart_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('chart_id')->nullable();
            $table->foreign('chart_id')->references('id')->on('charts')->onDelete('cascade');

            $table->unsignedInteger('taxpayer_id')->nullable();
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->string('name');

            $table->unsignedTinyInteger('type')->default(1)
            ->comment('1 = Cash and Bank Accounts
            2 = Accounts Receivable
            3 = Undeposited Funds
            4 = Inventory
            5 = Fixed Assets Groups
            6 = Prepaid Insurance
            7 = Sales Tax Credit

            8 = Accrued Liablities
            9 = Accounts Payable
            10 = Payroll liabilities
            11 = Notes Payable

            ... More to come.
            ');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('chart_accounts');
    }
}
