<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\mainController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\itemController;
use App\Http\Controllers\api\restaurantAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'v1','namespace'=>'api'],function(){
    ////////////////////////////////////////////start main controller
    Route::get('cities',[mainController::class,'cities']);
    Route::get('regions',[mainController::class,'regions']);
    //الجزء الخاص باالمطاعم
    Route::get('restaurants',[mainController::class,'restaurants']);
    Route::get('restaurant',[mainController::class,'restaurant']);
    Route::get('restaurantitems',[mainController::class,'restaurantitems']);
    //الجزء الخاص باالتعليقات
    Route::get('comments',[mainController::class,'comments']);
    Route::post('addComment',[mainController::class,'addComment']);
    //بدايه الجزء الخاص ب الاوردرات
    Route::post('addorder',[mainController::class,'addorder']);
    Route::get('orders',[mainController::class,'orders']);
    Route::get('order',[mainController::class,'order']);
    Route::get('order_details',[mainController::class,'orderdetails']);
    Route::post('addorder_details',[mainController::class,'addorderdetails']);
    //////////////////////////////////////////////////end main controller
    //////////////////start auth controller//////////////////////////////
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::Post('reset',[AuthController::class,'reset']);
    Route::Post('Password',[AuthController::class,'Password']);
    //////////////////end auth controller////////////////////////////////
    //////////////////start restaurantAuth controller//////////////////////////////
    Route::post('resturant_register',[restaurantAuthController::class,'register']);
    Route::post('login',[restaurantAuthController::class,'login']);
    //////////////////end restaurantAuth controller////////////////////////////////
    Route::group(['middleware'=>'auth:api'],function(){
        Route::get('test',function(){
            return "test";
        });
         // start Auth
            Route::get('showData',[AuthController::class,'showData']);
            Route::get('update_profile',[AuthController::class,'update_profile']);
            // Route::Post('reset',[AuthController::class,'reset']);
            // Route::Post('Password',[AuthController::class,'Password']);
          // end Auth
    });
    Route::group(['middleware'=>'auth:apirestaurant'],function(){
        Route::get('test01',function(){
            return 'doifojs;foiuoauoijdoisajoijoasjfoijnvas';
        });
        //start items route///////
        Route::get('items',[itemController::class,'index']);
        Route::post('addorder',[itemController::class,'addorder']);
        //end items route////////
    });
});
