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

Route::get('/', 'App\Http\Controllers\ManageSubscribersController@index')->name('subscriber.index');
Route::get('/subscriber/create', 'App\Http\Controllers\ManageSubscribersController@create')->name('subscriber.create');
Route::post('/subscriber/create', 'App\Http\Controllers\ManageSubscribersController@store')->name('subscriber.store');
Route::get('/subscriber/unsubscribe/{id}', 'App\Http\Controllers\ManageSubscribersController@unsubscribe')->name('subscriber.unsubscribe');
Route::get('/subscriber/delete/{id}', 'App\Http\Controllers\ManageSubscribersController@delete')->name('subscriber.delete');
