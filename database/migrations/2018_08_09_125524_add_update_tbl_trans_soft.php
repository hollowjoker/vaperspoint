<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUpdateTblTransSoft extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_transactions', function (Blueprint $table) {
            $table->decimal('price',11,2)->change();
            $table->decimal('amount',11,2)->change();
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
        Schema::table('Tbl_transactions', function (Blueprint $table) {
            $table->decimal('price',5,2)->change();
            $table->decimal('amount',5,2)->change();
        });
    }
}
