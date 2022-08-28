<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'description','minimum_order','mobile_communication','Image','delivery','whatsapp', 'status','region_id','category_id','password','pin_code');
    protected $hidden = [
        'password', 'api_token','notification_token'
    ];
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
    public function Category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
