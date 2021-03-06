<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public function customer(){
        return $this->belongsTo('App\Model\Customer', 'customer_id');
    }

    public function orderDetail(){
        return $this->hasOne('App\Model\OrderDetail');
    }

    public function bill(){
        return $this->hasOne('App\Model\Bill');
    }
}
