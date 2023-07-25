<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductImageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login'])->middleware('checkverified');
    Route::get('logout', [AuthController::class,'logout'])->middleware('auth');
    Route::post('register', [AuthController::class,'register']);
    Route::post('forgotpass', [AuthController::class,'forgot']);
    Route::post('resetcode', [AuthController::class,'resetcode']);
    Route::post('resetpass', [AuthController::class,'resetpass']);
    Route::get('info',[AuthController::class,'personalinfo'])->middleware('auth');
    Route::post('updateinfo',[AuthController::class,'updateinfo'])->middleware('auth');
    Route::post('code', [AuthController::class,'verifyphone']);
    Route::get('notificaton',[AuthController::class,'notification'])->middleware('auth');


/*--------------------------------------------------------------------------------------*/
                                    //countries

    Route::post('country/store',[CountryController::class,'store'])->middleware('auth','checkadmin');
    Route::post('country/update/{id}',[CountryController::class,'update'])->middleware('auth','checkadmin');
    Route::get('country/index',[CountryController::class,'index']);
    Route::get('country/delete/{id}',[CountryController::class,'destroy'])->middleware('auth','checkadmin');


/*-----------------------------------------------------------------------------------------*/
                                    //categories

    Route::post('category/store',[CategoryController::class,'store'])->middleware('auth','checkadmin');
    Route::post('category/update/{id}',[CategoryController::class,'update'])->middleware('auth','checkadmin');
    Route::get('category/show/{id}',[CategoryController::class,'show'])->middleware('auth');
    Route::get('category/index',[CategoryController::class,'index'])->middleware('auth');
    Route::get('category/delete/{id}',[CategoryController::class,'destroy'])->middleware('auth','checkadmin');


/*----------------------------------------------------------------------------------------- */
                                    //product image

    Route::post('product_image/store/{id}',[ProductImageController::class,'store'])->middleware('auth','checkadmin');
    Route::post('product_image/update/{id}',[ProductImageController::class,'update'])->middleware('auth','checkadmin');
    Route::get('product_image/show/{id}',[ProductImageController::class,'show'])->middleware('auth');
    Route::get('product_image/index',[ProductImageController::class,'index'])->middleware('auth');
    Route::get('product_image/delete/{id}',[ProductImageController::class,'destroy'])->middleware('auth','checkadmin');



/*-------------------------------------------------------------------------------------------*/
                                    //product

    Route::post('product/store/{id}',[ProductController::class,'store'])->middleware('auth','checkadmin');
    Route::post('product/update/{id}',[ProductController::class,'update'])->middleware('auth','checkadmin');
    Route::get('product/show/{id}',[ProductController::class,'show'])->middleware('auth');
    Route::get('product/index',[ProductController::class,'index'])->middleware('auth');
    Route::get('product/delete/{id}',[ProductController::class,'destroy'])->middleware('auth','checkadmin');
    Route::post('product/sortdesc',[ProductController::class,'sortdesc'])->middleware('auth');


    /*----------------------------------------------------------------------------------------*/
                                    //search

    Route::post('search/{term}',[SearchController::class,'search'])->middleware('auth');

    /*--------------------------------------------------------------------------------------- */
                                    //basket

    Route::get('basket/index',[BasketController::class,'index'])->middleware('auth');
    Route::post('basket/store',[BasketController::class,'store'])->middleware('auth');
    Route::get('basket/delete/{id}',[BasketController::class,'destroy'])->middleware('auth');
    Route::get('basket/add/{id}',[BasketController::class,'add_one'])->middleware('auth');
    Route::get('basket/remove/{id}',[BasketController::class,'remove_one'])->middleware('auth');
    Route::get('basket/price',[BasketController::class,'total_price'])->middleware('auth');


    /*-----------------------------------------------------------------------------------------*/
                                    //order

    Route::post('order/store',[OrderController::class,'store'])->middleware('auth');
    Route::get('order/current',[OrderController::class,'index'])->middleware('auth');
    Route::get('order/cancel/{id}',[OrderController::class,'destroy'])->middleware('auth');
    Route::get('order/finished',[OrderController::class,'show'])->middleware('auth');
    Route::post('order/update/{id}',[OrderController::class,'update'])->middleware('auth','checkadmin');


    /*------------------------------------------------------------------------------------------*/
                                    //address

    Route::post('address/store',[AddressController::class,'store'])->middleware('auth');
    Route::get('address/index',[AddressController::class,'index'])->middleware('auth');
    Route::get('address/delete/{id}',[AddressController::class,'destroy'])->middleware('auth');


    /*-------------------------------------------------------------------------------------------*/
                                    //rate

    Route::post('rate/store',[RateController::class,'store'])->middleware('auth');
    Route::get('rate/index/{id}',[RateController::class,'index'])->middleware('auth');
    Route::post('rate/update/{id}',[RateController::class,'update'])->middleware('auth');
    Route::get('rate/delete/{id}',[RateController::class,'destroy'])->middleware('auth');


    /*------------------------------------------------------------------------------------------*/


    Route::post('favorite/store',[FavoriteController::class,'store'])->middleware('auth');
    Route::get('favorite/index',[FavoriteController::class,'index'])->middleware('auth');
    Route::get('favorite/delete/{id}',[FavoriteController::class,'destroy'])->middleware('auth');
});


