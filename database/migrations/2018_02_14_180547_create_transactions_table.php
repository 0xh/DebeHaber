<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table)
        {
            $table->increments('id');

            $table->unsignedTinyInteger('type')->default(1)
            ->comment('1 = Purchases, 2 = Self-Invoice (Purchases), 3 = Sales Invoice');

            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->unsignedInteger('document_id')->nullable();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

            $table->unsignedInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->unsignedDecimal('rate', 10, 4)->default(1);

            $table->unsignedInteger('payment_condition')->default(0);

            $table->date('date');

            $table->string('number', 30)->nullable();

            $table->string('code', 18)->nullable();

            $table->date('code_expiry')->nullable();

            $table->string('comment')->nullable();

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
        Schema::dropIfExists('transactions');
    }
}
