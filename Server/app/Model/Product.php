<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public function productSubCategory(){
        return $this->belongsTo('App\Model\ProductSubCategory', 'product_sub_category_id');
    }

    public function orderDetail(){
        return $this->hasMany('App\Model\OrderDetail');
    }


}
