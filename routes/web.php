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
Route::get('/poi/addpoi', 'PoiController@addPoi');
Route::get('/poi/poimanager', function() {
    return view('poimanager');
});
Route::post('/poi/uploadcsv', 'PoiController@uploadcsv');

Route::get('/poi/successpoi', function() {
    return view('files.successPoi');
});

Route::get('/poi/errorpoi', function() {
    return view('files.errorPoi');
});
Route::get('/poi/editPoi', 'PoiController@editPoi');
Route::get('/poi/index', 'PoiController@index');
Route::get('/poi/', 'PoiController@index');
