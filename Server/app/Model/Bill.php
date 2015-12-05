<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function customer(){
        return $this->belongsToMany('App\Model\Customer', 'customer_id');
    }

    public function order(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }
}
