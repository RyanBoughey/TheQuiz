<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'ResponceController@index')->name('index');
Route::post('/confirm', 'ResponceController@create')->name('confirm');
Route::post('/', 'ResponceController@store')->name('store_responce');
Route::get('/{responce}', 'ResponceController@show')->name('show_responce');
Route::put('/{responce}', 'ResponceController@update')->name('update_responce');
