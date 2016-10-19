<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'api/v1.0'], function() {
    Route::get('/main', 'v1_0\v1m0_MainController@index');
    Route::get('/category', 'v1_0\v1m0_CategoryController@index');
    Route::get('/poi', 'v1_0\v1m0_PoiController@index');
    Route::get('/poi/getpoisbyid/{id}', 'v1_0\v1m0_PoiController@getPoisById');
    Route::get('/poi/getpois', 'v1_0\v1m0_PoiController@getPois');
    Route::get('/category/getcategories', 'v1_0\v1m0_categoryController@getCategories');
    Route::get('/category/getcategorybyid/{id}', 'v1_0\v1m0_categoryController@getCategoryById');

});


Route::group(['prefix' => 'api/v1.1'], function() {
    Route::get('/main', 'v1_1\v1m1_MainController@index');

});