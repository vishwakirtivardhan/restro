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
// popupOpenItem
Route::get('/home', 'HomeController@index')->name('home');
Route::get('menu', 'HomeController@menu')->name('menu');
Route::post('menu_save', 'HomeController@menu_save')->name('menu_save'); 
Route::get('new_order', 'HomeController@new_order')->name('new_order');
Route::get('popupOpenItem', 'HomeController@popupOpenItem');

Route::post('save_menu', 'HomeController@save_order');
Route::get('orderStausChange', 'HomeController@orderStatus');
Route::get('menuStatus', 'HomeController@menuStatus');
Route::get('report', 'HomeController@customReport');
Route::get('updatePrice','HomeController@updatePrice');
//Route::post('/print', function() { return view('pages/ajax_popupOpenItem'); });