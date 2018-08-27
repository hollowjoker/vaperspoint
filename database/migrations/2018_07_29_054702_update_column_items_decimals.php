<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnItemsDecimals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_items', function (Blueprint $table) {
            $table->decimal('price',11,2)->change();
            $table->decimal('srp_price',11,2)->change();
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
            $table->decimal('price',5,2)->change();
            $table->decimal('srp_price',5,2)->change();
        });
    }
}
