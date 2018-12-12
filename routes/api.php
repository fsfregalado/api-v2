<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/article', 'ArticleController')->middleware('cors');

Route::resource('/user', 'UserController')->middleware('cors');

Route::resource('/usertype', 'UserTypeController')->middleware('cors');

//give the articles and its users
Route::get('/userarticle', 'ArticleController@getArticleAndUser')->middleware('cors');

Route::get('/authuser', 'UserController@getAuthUser')->middleware('cors')->middleware('auth:api');