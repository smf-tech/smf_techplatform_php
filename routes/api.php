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

Route::middleware('auth:api')->get('/users', function (Request $request) {
    return $request->user();
});

//Route::get('/getTestEndpoint','smsAuthController@getTestEndpoint');




Route::group(['middleware' => ['api']], function () {
    Route::post('auth/login', 'ApiController@login');
    Route::group(['middleware' => 'auth.jwt'], function () {
    //    Route::get('user', 'ApiController@getAuthUser');
        Route::get('logout', 'ApiController@logout');
    });
    Route::group(['middleware' => 'refresh.jwt'], function () {
        Route::get('token/refresh', 'ApiController@refresh');
    });
});


