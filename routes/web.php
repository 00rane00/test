<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "ImageController@list");
Route::get('/show/{lib_id}', "ImageController@show")->name('show');

Route::post('/createLib',"ImageController@createLib");
Route::post('/saveImage',"ImageController@saveImage");

Route::post('/deleteImage',"ImageController@deleteImage");