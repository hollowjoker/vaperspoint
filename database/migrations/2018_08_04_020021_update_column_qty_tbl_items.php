<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnQtyTblItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_item_imported_transactions', function (Blueprint $table) {
            $table->integer('qty')->change();
        });

        Schema::table('Tbl_items', function (Blueprint $table) {
            $table->integer('qty')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_item_imported_transactions', function (Blueprint $table) {
            $table->decimal('qty',11,2)->change();
        });
    }
}
