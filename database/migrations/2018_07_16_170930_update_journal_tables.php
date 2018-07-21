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
            $table->boolean('update_required')->default(false)->after('id');
        });

        //
        Schema::rename('journal_productions', 'journal_production');
        Schema::table('journal_production', function (Blueprint $table) {
            $table->boolean('update_required')->default(false)->after('id');
        });

        //
        Schema::rename('journal_account_movements', 'journal_account_movement');
        Schema::table('journal_account_movement', function (Blueprint $table) {
            $table->boolean('update_required')->default(false)->after('id');
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
