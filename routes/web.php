<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('login/', function () {
    return response()->json(['error'=>"not logged in"], 200);
});
Route::prefix('market')->group(function () {
    Route::get('/{id}',"MarketController@show");
    Route::get('/category/showall',"MarketController@showall");
    Route::get('/view/image/{id}',"MarketController@down_image")->name("market_image_route");
    Route::middleware('auth:api')->post('/add',"MarketController@store");
    Route::middleware('auth:api')->get('/delete/{id}',"MarketController@destroy");
    Route::middleware('auth:api')->post('/update/{id}',"MarketController@update");
});