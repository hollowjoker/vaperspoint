<?php

use Illuminate\Http\Request;

use App\Library\ClassFactory as CF;

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


Route::group(['middleware' => ['api']], function(){
    
	Route::get('/test', function (Request $request) {
        $data = CF::model('Category')
        ->with('Item')
        ->with('Item_detail')
        ->get();
        return $data;
    });
});
