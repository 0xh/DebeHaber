<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MissingFieldsjournal extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        //Company or Integration Fields
        Schema::table('journals', function (Blueprint $table)
        {
          $table->unsignedInteger('taxpayer_id');
          $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');
        });

        
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        //
    }
}
