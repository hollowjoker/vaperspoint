<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_transaction extends Model
{
    protected $fillable = [
        'tbl_customer_id',
        'transaction_no',
        'worker_id',
        'tbl_user_id',
        'tbl_item_id',
        'qty',
        'type',
        'price',
        'amount',
        'date_trans',
    ];
}
