<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model 
{

    protected $table = 'orders_details';
    public $timestamps = true;
    protected $fillable = array('order_id', 'item_id', 'quantity', 'price', 'additions', 'payingoff', 'deliveryfee');

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

}