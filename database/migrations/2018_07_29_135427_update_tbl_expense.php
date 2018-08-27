<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_expenses', function (Blueprint $table) {
            $table->integer('user_id')->after('id');
            $table->decimal('amount',11,2)->after('user_id');
            $table->text('description')->after('amount');
            $table->datetime('date_from')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_expenses', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('description');
            $table->dropColumn('date_from');
            $table->dropColumn('user_id');
        });   
    }
}
