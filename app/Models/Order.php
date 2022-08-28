<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'total_price', 'state','restaurant_id','address','total','delivery_price','site_commission');

    public function orderdetails()
    {
        return $this->hasMany('App\Models\OrderDetails');
    }

}
