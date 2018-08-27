<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('item_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('qty')->default(0);
            $table->string('size',50)->nullable();
            $table->decimal('srp_price',5,2);
            $table->decimal('price',5,2);
            $table->text('supplier');
            $table->timestamp('date_added');
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
        Schema::dropIfExists('tbl_items');
    }
}
