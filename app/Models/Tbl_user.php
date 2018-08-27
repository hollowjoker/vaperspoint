<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_user extends Model
{
    public function expense(){
        return $this->hasOne('App\Models\Tbl_expense');
    }
}
