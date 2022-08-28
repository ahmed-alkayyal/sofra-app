<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Resturant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class restaurantAuthController extends Controller
{
    public function register(Request $request){
        $validator=validator()->make($request->all(),[
            'name'                          => 'required',
            'email'                         => 'required|email|unique:restaurants',
            'phone'                         => 'required',
            'description'                   => 'required',
            'password'                      => 'required',
            'minimum_order'                 => 'required',//التسميه هنا غلط ولا صح؟
            'mobile_communication'          => 'required',//التسميه هنا غلط ولا صح؟
            'Image'                         => 'required',
            'delivery'                      => 'required',
            'whatsapp'                      => 'required',
            'status'                        => 'required',
            'region_id'                     => 'required|exists:regions,id',
            'city_id'                       => 'required|exists:cities,id',
            'category_id'                   => 'required|exists:categories,id',

        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['password'=>bcrypt($request->password)]);
        $resturant=Resturant::create($request->all());
        $resturant->api_token=Str::random(60);
        $resturant->save();
        return responsejson(1,"تم الاضافه بنجاح",[
            'api_token' =>$resturant->api_token,
            'client'=>$resturant
        ]);
        // return responsejson(1,"تم الاضافه بنجاح",$resturant);
    }
    public function login(Request $request){
        $validator=validator()->make($request->all(),[
            'email'                         => 'required',
            'password'                      => 'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        // return auth()->guard('apirestaurant')->validate($request->all());
        $resturant=Resturant::where('email',$request->email)->first();
        if($resturant){
            if(Hash::check($request->password,$resturant->password)){
                return responsejson(1,"البيانات صحيحه",[
                    'api_token' =>$resturant->api_token,
                    'client'=>$resturant
                ]);
            }else{
                return responsejson(0,'البانات خاطئه');
            }

        }else{
            return responsejson(0,'لايوجد حساب بهذهي البيانات');
        }
    }
}
