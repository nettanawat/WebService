<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    public function order(){
        return $this->belongsTo('App\Model\Order', 'order_id');
    }
}
