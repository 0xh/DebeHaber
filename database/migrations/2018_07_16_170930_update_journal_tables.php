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
        Schema::dropIfExists('journal_sim_details');
        Schema::dropIfExists('journal_sims');

        Schema::dropIfExists('journal_transactions');
        Schema::dropIfExists('journal_productions');
        Schema::dropIfExists('journal_account_movements');

        Schema::dropIfExists('journal_details');
        Schema::dropIfExists('journals');

        Schema::create('journals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedInteger('cycle_id');
            $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('cascade');

            $table->unsignedMediumInteger('number')->nullable();

            $table->date('date');

            $table->string('comment', 64);

            $table->boolean('is_automatic')->default(false)->comment('helps identify the transactions made by user');
            $table->boolean('is_presented')->default(false)->comment('If Journal has been presented and now allow further changes.');
            $table->boolean('is_first')->default(false)->comment('Refers to if Journal is an Opening Balance. Can only be one per Accounting Cycle');
            $table->boolean('is_last')->default(false)->comment('Refers to if Journal is an Closing Balance. Can only be one per Accounting Cycle');;

            $table->timestamps();
        });

        Schema::create('journal_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('journal_id');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

            $table->unsignedInteger('chart_id');
            $table->foreign('chart_id')->references('id')->on('charts')->onDelete('cascade');

            $table->unsignedDecimal('debit', 18, 2)->default(0);
            $table->unsignedDecimal('credit', 18, 2)->default(0);

            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('journal_id')->nullable()->index()->after('type');
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->uuid('journal_id')->nullable()->index()->after('taxpayer_id');
        });

        Schema::table('account_movements', function (Blueprint $table) {
            $table->uuid('journal_id')->nullable()->index()->after('taxpayer_id');
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
