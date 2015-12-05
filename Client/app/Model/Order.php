<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function bill(){
        return $this->hasOne('App\Model\Bill');
    }
}
