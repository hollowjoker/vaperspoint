<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tbl_expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tbl_user_id',
        'date_from',
        'amount',
        'description',
    ];

    protected $dates = ['delete_at'];

    public function users(){
        return $this->belongsTo('App\Models\Tbl_expense');
    }
}
