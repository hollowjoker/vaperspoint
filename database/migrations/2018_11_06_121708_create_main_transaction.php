<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->string('transaction_no');
            $table->decimal('total_amount',11,2);
            $table->decimal('downpayment',11,2);
            $table->decimal('balance',11,2);
            $table->softDeletes();
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
        Schema::dropIfExists('main_transactions');
    }
}
