<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_no', 20);
            $table->integer('worker_id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->string('type', 20);
            $table->integer('qty');
            $table->decimal('price',5,2);
            $table->decimal('amount',5,2);
            $table->date('date_trans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_transactions');
    }
}
