<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    public function customerAddress(){
        return $this->hasOne('App\Model\CustomerAddress');
    }

    public function orderDetail(){
        return $this->hasMany('App\Model\OrderDetail');
    }
}
