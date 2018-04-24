<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InventoryTableUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('inventories', function (Blueprint $table)
        {
            $table->dropColumn(['date', 'current_value']);

            $table->date('start_date')->after('chart_id');
            $table->date('end_date')->after('start_date');

            $table->unsignedDecimal('sales_value', 18, 2)->after('end_date');
            $table->unsignedDecimal('cost_value', 18, 2)->after('sales_value');
            $table->unsignedDecimal('inventory_value', 18, 2)->after('cost_value');
            $table->string('chart_of_incomes')->after('inventory_value');
            $table->string('comments')->after('chart_of_incomes');
        });

        Schema::table('charts', function (Blueprint $table)
        {
            $table->unsignedDecimal('asset_years', 4, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table)
        {
            $table->date('date');
            $table->unsignedDecimal('current_value', 18, 2);
            
            $table->dropColumn(['start_date', 'end_date', 'sales_value', 'cost_value', 'inventory_value', 'chart_of_incomes', 'comments']);
        });
    }
}
