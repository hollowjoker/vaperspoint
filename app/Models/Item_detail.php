<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_detail extends Model
{
    public function Item_detail(){
        return $this->hasOne('App\Models\Item_detail', 'item_id');
    }
}
