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

Route::post('/register', 'RegisterController@register');

Route::group(['prefix' => 'pages'], function() {
    Route::post('/', 'PageController@add_page')->middleware('jwt.auth');
});

//Authentication JWT
Route::get('/auth/token', 'TokenController@auth');
Route::get('/auth/refresh', 'TokenController@refresh');
Route::get('/auth/token/invalidate', 'TokenController@invalidate');
Route::get('/auth/isvalid', 'TokenController@isvalid');
