<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function Item_detail(){
        return $this->hasMany('App\Models\Item_detail', 'item_id');
    }
}
