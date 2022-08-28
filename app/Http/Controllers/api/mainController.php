<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Region;
use App\Models\Resturant;
use Illuminate\Http\Request;

class mainController extends Controller
{
    //الجزي الخاص باالمكان
    public function cities(){
        $cities=City::all();
        return responsejson(1,'ناجح',$cities);
    }
    public function regions(Request $request){
        $regions=Region::where(function($query) use($request){
            if($request->has('city_id')){
                $query->where('city_id',$request->city_id);
            }
        })->get();
        return responsejson(1,'ناجح',$regions);

    }
    //الجزء الخاص باالمطاعم
    public function restaurants(Request $request){
        $restaurants=Resturant::where(function($query) use($request){
            if( $request->has('city_id') ){
                $query->where('city_id',$request->city_id);
            }
            // if($request->has('resturains_id')){
            //     $query->where('id',$request->resturains_id);
            // }

        })->get();
        return responsejson(1,'success',$restaurants);
    }
    public function restaurant(Request $request){
        $restaurant=Resturant::find($request->id);
        if($restaurant){
            return responsejson(1,'success',$restaurant);
        }
        return responsejson(0,'error');
    }
    //الجزء الخاص اصناف المطاعم
    public function restaurantitems(Request $request){
        $items=Item::where(function($query) use($request){
            if($request->has('restaurant_id')){
                $query->where('restaurant_id',$request->restaurant_id);
            }
        })->get();
        return responsejson(1,'success',$items);
    }
    //الجزء الخاص باالتعليقات
    //عرض التعليقات
    public function comments(Request $request){
        $comments=Comment::where(function($query) use($request){
            if($request->has('restaurant_id')){
                $query->where('restaurant_id',$request->restaurant_id);
            }
            if($request->has("client_id")){
                $query->where('client_id',$request->client_id);
            }
        })->paginate(10);
        return responsejson(1,'تم بنجاح',$comments);
    }
    //اضافه تعليقات
    public function addComment(Request $request){
        $validator=validator()->make($request->all(),[
            'client_id'         => 'required|exists:clients,id',
            'comment'           => 'required',
            'emoji'             => 'required',
            'restaurant_id'     => 'required|exists:restaurants,id'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $addcomment=Comment::create($request->all());
        return responsejson(1,'تم اضافه تعليقك بنجاح',$addcomment);
    }
    //نهايه الجزء الخاص باالتعليقات
    //بدايه الجزء الخاص ب الاوردرات
    public function orders(Request $request){
        $orders=Order::where('restaurant_id',$request->restaurant_id)->where('client_id',$request->client_id)->paginate(10);
        return responsejson(1,'تم بنجاح',$orders);
    }
    public function order(Request $request){
        $order=Order::where('id',$request->order_id)->first();
        return responsejson(1,'تم بنجاح',$order);
    }
    public function addOrder(Request $request){
        $validator=validator()->make($request->all(),[
            'client_id'             => 'required|exists:clients,id',
            'total_price'           => 'required',
            'state'                 => 'required|in:pending,accepted,rejected,delivered,decliened',
            'restaurant_id'         => 'required|exists:restaurants,id',
            'address'               => 'required',
            'total'                 => 'required',
            'delivery_price'        => 'required',
            'site_commission'       => 'required'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $addorder=Order::create($request->all());
        return responsejson(1,'تم اضافه الاوردر بنجاح',$addorder);
    }
    public function orderdetails(Request $request){
        $orderdetails=OrderDetails::where('order_id',$request->order_id)->first();
        return responsejson(1,'تم بنجاح',$orderdetails);
    }
    public function addorderdetails(Request $request){
        $validator=validator()->make($request->all(),[
            'order_id'           => 'required|exists:orders,id',
            'item_id'            => 'required|exists:items,id',
            'quantity'           => 'required',
            'price'              => 'required',
            'additions'          => 'required',
            'payingoff'          => 'required',
            'deliveryfee'        => 'required'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $addorderdetails=OrderDetails::create($request->all());
        return responsejson(1,'تم اضافه الاوردر بنجاح',$addorderdetails);
    }
    //نهايه الجزء الخاص باالاغوردرات
}
