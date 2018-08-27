<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tbl_category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_name',
        'description',
        'type'
    ];

    protected $dates = ['delete_at'];
}
