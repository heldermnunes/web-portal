<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('/api', function() {
    return '<h1>api</h1>
'; });
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/poi/addPoi', 'PoiController@addPoi');
Route::get('/poi/editPoi', 'PoiController@editPoi');
Route::get('/poi/index', 'PoiController@index');
Route::get('/poi/', 'PoiController@index');
