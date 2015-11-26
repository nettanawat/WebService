<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    protected $table = 'product_sub_categories';
    public function productCategory(){
        return $this->belongsTo('App\Model\ProductCategory', 'product_category_id');
    }

    public function product(){
        return $this->hasMany('App\Model\Product');
    }
}
