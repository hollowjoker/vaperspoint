<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblItemImportedTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_item_imported_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('trans_code');
            $table->integer('item_id');
            $table->decimal('qty',11,2);
            $table->decimal('srp_price',11,2);
            $table->decimal('price',11,2);
            $table->decimal('amount',11,2);
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
        Schema::dropIfExists('tbl_item_imported_transactions');
    }
}
