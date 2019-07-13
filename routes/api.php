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
Route::post('user/login', 'AuthController@login');
Route::post('member/list', 'HomeController@viewMember');
Route::post('add/member', 'HomeController@insertMember');
Route::post('single/member', 'HomeController@editMember');
Route::post('update/member', 'HomeController@updateMember');
Route::post('detail/member', 'HomeController@detailsMember');
