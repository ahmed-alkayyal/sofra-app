<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model 
{

    protected $table = 'item_order';
    public $timestamps = true;
    protected $fillable = array('item_id', 'order_id');

}