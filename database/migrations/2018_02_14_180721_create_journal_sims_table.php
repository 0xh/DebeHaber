<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalSimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_sims', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('cycle_id');
            $table->foreign('cycle_id')->references('id')->on('cycles')->onDelete('cascade');

            $table->unsignedInteger('journal_id')->nullable();
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');

            $table->unsignedSmallInteger('code')->nullable();

            $table->date('date');

            $table->string('comment', 64);

            $table->boolean('is_first')->default(false);
            $table->boolean('is_last')->default(false);

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
        Schema::dropIfExists('journal_sims');
    }
}
