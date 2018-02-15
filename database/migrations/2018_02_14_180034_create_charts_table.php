<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('charts')->onDelete('cascade');

            $table->unsignedInteger('chart_version_id');
            $table->foreign('chart_version_id')->references('id')->on('chart_versions')->onDelete('cascade');

            $table->unsignedInteger('taxpayer_id')->nullable();
            $table->foreign('taxpayer_id')->references('id')->on('taxpayers')->onDelete('cascade');

            $table->string('country', 2)->default('PY');

            $table->string('code');
            $table->string('name');

            $table->unsignedTinyInteger('type')->default(1)->comment('
            1 = Asset
            2 = Liabilities
            3 = Capital
            4 = Income
            5 = Expense
            ');
            $table->unsignedTinyInteger('level')->default(1);
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
        Schema::dropIfExists('charts');
    }
}
