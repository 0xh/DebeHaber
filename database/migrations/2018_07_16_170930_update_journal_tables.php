<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJournalTables extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->boolean('is_automatic')->default(false)->after('comment')->comment('helps identify the transactions made by user');

            // $table->unsignedTinyInteger('type')->after('cycle_id')->nullable()
            // ->comment('1  = Purchases, 2 = Self-Invoice (Purchases), 3 = Debit Note (Purchase), 4 = Sales Invoice, 5 = Credit Note (Sales)');

            $table->dropColumn('id');
            $table->char('id', 36)->primary();
        });

        Schema::table('journal_details', function (Blueprint $table) {
            $table->dropColumn('journal_id');
            $table->char('journal_id', 36)->index()->after('type');
        });

        Schema::dropIfExists('journal_transactions');

        Schema::table('transactions', function (Blueprint $table) {
            $table->char('journal_id', 36)->index()->after('type');
        });

        Schema::dropIfExists('journal_productions');

        Schema::table('productions', function (Blueprint $table) {
            $table->char('journal_id', 36)->index()->after('taxpayer_id');
        });

        Schema::dropIfExists('journal_account_movements');

        Schema::table('account_movements', function (Blueprint $table) {
            $table->char('journal_id', 36)->index()->after('taxpayer_id');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        // Schema::create('journal_account_movements', function (Blueprint $table) {
        //     $table->increments('id');
        // });
        // Schema::create('journal_productions', function (Blueprint $table) {
        //     $table->increments('id');
        // });
        // Schema::create('journal_transactions', function (Blueprint $table) {
        //     $table->increments('id');
        // });
        //
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn('is_automatic');
        });
    }
}
