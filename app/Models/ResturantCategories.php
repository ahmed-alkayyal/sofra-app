<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResturantCategories extends Model 
{

    protected $table = 'restaurants_categories';
    public $timestamps = true;
    protected $fillable = array('restaurant_id', 'category_id');

}