<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnItemsTotals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_items', function (Blueprint $table) {
            $table->decimal('total_item_buy',11,2)->after('price');
            $table->decimal('total_item_sell',11,2)->after('total_item_buy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_items', function (Blueprint $table) {
            $table->dropColumn('total_item_buy');
            $table->dropColumn('total_item_sell');
        });
    }
}
