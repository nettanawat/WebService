<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{

    protected $table = 'order_details';
    public function order(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product', 'product_id');
    }

}
