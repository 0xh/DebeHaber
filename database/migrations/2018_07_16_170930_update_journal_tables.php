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
            $table->boolean('is_automatic')->default(false)->after('comment');
        });

        //
        Schema::rename('journal_transactions', 'journal_transaction');

        Schema::table('journal_transaction', function (Blueprint $table) {
            $table->boolean('require_update')->default(false)->after('id');
        });

        Schema::table('journal_transaction', function (Blueprint $table) {
            $table->boolean('require_update')->default(false)->after('id');
        });

        Schema::rename('journal_productions', 'journal_production');
        Schema::rename('journal_account_movements', 'journal_account_movement');
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
