<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('tbl_expenses', function (Blueprint $table) {
            $table->renameColumn('user_id', 'tbl_user_id');
        });
        
        Schema::table('tbl_item_imported_transactions', function (Blueprint $table) {
            $table->renameColumn('item_id', 'tbl_item_id');
        });

        Schema::table('tbl_items', function (Blueprint $table) {
            $table->renameColumn('category_id', 'tbl_category_id');
        });
        
        Schema::table('tbl_transactions', function (Blueprint $table) {
            $table->renameColumn('user_id', 'tbl_user_id');
            $table->renameColumn('item_id', 'tbl_item_id');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('tbl_expenses', function (Blueprint $table) {
            $table->renameColumn('tbl_user_id', 'user_id');
        });
        
        Schema::table('tbl_item_imported_transactions', function (Blueprint $table) {
            $table->renameColumn('tbl_item_id', 'item_id');
        });

        Schema::table('tbl_items', function (Blueprint $table) {
            $table->renameColumn('tbl_category_id', 'category_id');
        });
        
        Schema::table('tbl_transactions', function (Blueprint $table) {
            $table->renameColumn('tbl_user_id', 'user_id');
            $table->renameColumn('tbl_item_id', 'item_id');
        });
    }
}
