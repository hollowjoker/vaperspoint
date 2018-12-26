<?php

use Illuminate\Support\Facades\Route;
// product
Route::group(['prefix' => '/products', 'namespace' => '\App\Modules\Product'],function(){
    Route::get('/', 'ProductsController@index')->name('products');
    Route::get('/create', 'ProductsController@create')->name('products.create');
    Route::get('/show', 'ProductsController@show')->name('products.show');
    Route::get('/addForm', 'ProductsController@addForm')->name('products.add_form');
});

