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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home','HomeController@currentCurrencyRate')->name('get_currency_current_rate');
Route::post('/selectedcountry','HomeController@selectedcountry')->name('selectedcountry');
Route::post('/base_cur','HomeController@base_cur')->name('base_cur');
Route::post('/base','HomeController@base')->name('base');
Route::post('/history','HomeController@history')->name('history');


