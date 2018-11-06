<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('quantity')->default(0);

            $table->decimal('vip_price',5,2);
            $table->decimal('srp_price',5,2);
            $table->decimal('rsp_price',5,2);
            $table->decimal('retail');
            $table->integer('item_sell');
            $table->integer('total_stock');
            $table->integer('size');
            $table->integer('nic');
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
        //
    }
}
