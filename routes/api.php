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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::post('/login', 'Auth\LoginController@api_login');
Route::group(['middleware' => ['auth:api']], function () {
	Route::post('/sales/propose', 'AgentController@userStoreApi')->name('api.agent.propose');
	Route::get('/sales/providers', 'AgentController@providersListApi')->name('api.agent.providers');
	Route::post('/sales/test', 'AgentController@test_api')->name('api.agent.test');
});
