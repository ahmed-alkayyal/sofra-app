<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'items';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'image', 'price', 'offer_price', 'order_time');//'restaurant_id',

    public function ItemRestaurant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

}
