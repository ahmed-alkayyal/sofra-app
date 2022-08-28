<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class itemController extends Controller
{
    public function index(){
        $resturant=auth('apirestaurant')->user()->id;
        $item=Item::where('restaurant_id',$resturant)->paginate(10);
        return responsejson(1,'ناجح',$item);
    }
    public function addorder(Request $request){
        $resturant=auth('apirestaurant')->user()->id;
        $validator=validator()->make($request->all(),[
            'name'               => 'required',
            'image'              => 'required',
            'description'        => 'required',
            'price'              => 'required',
            'offer_price'        => 'required',
            'order_time'         => 'required',
            // 'restaurant_id'      => 'required|exists:restaurants,id'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $additems=Item::create($request->all());
        $additems->restaurant_id=$resturant;//في هنا خطأ مش عارفو
        dd($additems);
        $additems->save();
        return responsejson(1,'تم الاضافه بنجاح',$resturant);
    }
}
