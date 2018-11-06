<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->decimal('vip_price',11,2);
            $table->decimal('srp_price',11,2);
            $table->decimal('rsp_price',11,2);
            $table->decimal('retail',11,2);
            $table->integer('quantity')->default(0);
            $table->integer('item_sell');
            $table->integer('total_stock');
            $table->string('size',50)->nullable();
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
        Schema::dropIfExists('item_details');
    }
}
