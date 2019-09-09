<?php

use Illuminate\Http\Request;
use App\Market;
use App\Product;
use App\Image;
use App\Category;

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
Route::get('test', function () {
    return route('product_image_route',1);
});
Route::get('login', [ 'as' => 'login', 'uses' => 'Controller@login']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->name;
});
Route::prefix('market')->group(function () {
    Route::get('/{id}',"MarketController@show");
    Route::get('/category/showall',"MarketController@showall");
    Route::get('/view/image/{id}',"MarketController@down_image")->name("market_image_route");
    Route::middleware('auth:api')->post('/add',"MarketController@store");
    Route::middleware('auth:api')->get('/delete/{id}',"MarketController@destroy");
    Route::middleware('auth:api')->post('/update/{id}',"MarketController@update");
});
Route::prefix('product')->group(function () {
    Route::get('/{id}',"ProductController@show");
    Route::get('/category/{id}',"CategoryController@show");
    Route::get('/view/image/{id}',"MarketController@down_image")->name("product_image_route");
    Route::post('/add',"ProductController@store");
    Route::middleware('auth:api')->get('/delete/{id}',"ProductController@destroy");
    Route::middleware('auth:api')->post('/update/{id}',"ProductController@update");
});
Route::prefix('category')->group(function () {
    Route::middleware('auth:api')->post('/add',"CategoryController@store");
    Route::middleware('auth:api')->get('/delete/{id}',"CategoryController@destroy");
    Route::middleware('auth:api')->post('/update/{id}',"CategoryController@update");
});
