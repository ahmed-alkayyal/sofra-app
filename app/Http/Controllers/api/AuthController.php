<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator=validator()->make($request->all(),[
            'name'              => 'required',
            'email'             => 'required|email|unique:clients',
            'phone'             => 'required',
            'password'          => 'required',
            'region_id'         => 'required|exists:regions,id'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['password'=>bcrypt($request->password)]);
        $client=Client::create($request->all());
        $client->api_token=Str::random(60);
        $client->save();
        return responsejson(1,"تم الاضافه بنجاح",[
            'api_token' =>$client->api_token,
            'client'=>$client
        ]);
    }
    public function login(Request $request){
        $validator=validator()->make($request->all(),[
            'email'             => 'required|email',
            'password'          => 'required'
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $client=Client::where('email',$request->email)->first();
        if($client){
            if(Hash::check($request->password,$client->password)){
                return responsejson(1,"البيانات صحيحه",[
                    'api_token' =>$client->api_token,
                    'client'=>$client
                ]);
            }else{
                return responsejson(0,'البانات خاطئه');
            }

        }else{
            return responsejson(0,'لايوجد حساب بهذهي البيانات');
        }
    }
    public function showData(Request $request){
        $client=$request->user();
        return responsejson(1,'نجاح',$client);
    }
    public function update_profile(Request $request){
        $client=$request->user();
        if($client){
            $client->name=$request->name;
            $client->email=$request->email;
            $client->phone=$request->phone;
            $client->password=bcrypt($request->password);//راجع علي دي
            $client->region_id=$request->region_id;;
            $client->save();
        }else{
            return responsejson(0,'لا يوجد عميل بهذهي البيانات',$client);
        }
        return responsejson(1,'نجاح',$client);
    }
    public function reset(Request $request){
        $validator=validator()->make($request->all(),[
            'phone'=>'required',
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $user=Client::where('phone',$request->phone)->first();
        if($user){
            $code=rand(1111,9999);
            $user->pin_code=$code;
            // $user->save();
            $update=$user->update(['pin_code'=>$code]);
            if($update){

                Mail::to($request->user())
                    ->bcc('ahmedmohammedalkayyal@gmail.com')
                    ->send(new ResetPassword($code));
                    return responsejson(1,'برجاء فحص الايميل',[
                        'pin_code'=>$code,
                        'email'=>$user->email,
                    ]);
            }else{
                return responsejson(0,'حدث خطأ ما');
            }

        }
        return responsejson(0,'لا يوجد عميل بهذهي البيانات');
    }
    public function Password(Request $request){
        $validator=validator()->make($request->all(),[
            'phone'=>'required',
            'pin_code'=>'required',
            'password'=>'required|confirmed',
            /**
             * //|confirmed
             *  لما باجي اعمل كده بضيف حقل للتاكيد بسميه
             *pass_confirm
             */
        ]);
        if($validator->fails()){
            return responsejson(0,$validator->errors()->first(),$validator->errors());
        }
        $user=Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->
                            where('phone',$request->phone)->first();
        if($user){
            $user->password=bcrypt($request->pass);
            $user->pin_code=null;
            $user->save();
            if($user->save()){
                return responsejson(1,'تم التغير بنجاح');
            }else{
                return responsejson(0,"هناك خطأ ما");
            }

        }else{
            return responsejson(0,'هذا الكود خطأ');
        }
    }
}
