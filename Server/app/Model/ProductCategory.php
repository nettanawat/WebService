<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    public function productSubCategory(){
        return $this->hasMany('App\Model\ProductSubCategory');
    }
}
