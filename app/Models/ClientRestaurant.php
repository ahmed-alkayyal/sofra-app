<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientRestaurant extends Model 
{

    protected $table = 'client_restaurant';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id');

}