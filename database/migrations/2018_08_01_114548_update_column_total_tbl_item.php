<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnTotalTblItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_items', function (Blueprint $table) {
            $table->integer('total_item_buy')->default(0)->change();
            $table->integer('total_item_sell')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_items', function (Blueprint $table) {
            $table->decimal('total_item_buy',11,2)->change();
            $table->decimal('total_item_sell',11,2)->change();
        });
    }
}
