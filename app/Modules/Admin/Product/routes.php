<?php

use Illuminate\Support\Facades\Route;
// product
Route::group(['prefix' => '/products', 'namespace' => '\App\Modules\Product','middleware' => ['web','admin']],function(){
    Route::get('/', 'ProductsController@index')->name('products');
    Route::get('/create', 'ProductsController@create')->name('products.create');
    Route::get('/show', 'ProductsController@show')->name('products.show');
    Route::get('/addForm', 'ProductsController@addForm')->name('products.add_form');
    Route::post('/createItem', 'ProductsController@createItem')->name('products.create_item');
});

