<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tbl_items extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tbl_category_id',
        'item_name',
        'description',
        'qty',
        'size',
        'srp_price',
        'price',
    ];

    protected $dates = ['delete_at'];
}
