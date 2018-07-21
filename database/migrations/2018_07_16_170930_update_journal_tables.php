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
        // Schema::dropIfExists('journal_account_movements');
        // Schema::dropIfExists('journal_productions');
        // // Schema::dropIfExists('journal_transactions');
        // //
        Schema::table('journals', function (Blueprint $table) {
            $table->boolean('is_automatic')->default(false)->after('comment');
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
