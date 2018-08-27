<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCustomerTblTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_transactions', function (Blueprint $table) {
            $table->integer('tbl_customer_id')->after('transaction_no');
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
            $table->dropColumn('tbl_customer_id');
        }); 
    }
}
