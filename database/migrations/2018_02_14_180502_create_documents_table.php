<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('taxpayer_id');
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');

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

            $table->string('prefix');

            $table->unsignedInteger('mask');

            $table->unsignedSmallInteger('start_range')->default(1);
            $table->unsignedSmallInteger('current_range')->default(1);
            $table->unsignedSmallInteger('end_range')->default(100);

            $table->string('code')->nullable();
            $table->date('code_expiry')->nullable();

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
        Schema::dropIfExists('documents');
    }
}
