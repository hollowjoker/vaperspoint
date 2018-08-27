<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_item_imported_transaction extends Model
{
    protected $fillable = [
        'trans_code',
        'tbl_item_id',
        'qty',
        'srp_price',
        'price',
        'amount',
    ];
}
