<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function Item(){
        return $this->hasMany('App\Models\Item', 'category_id');
    }
    
}
