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

//routes Statuses
Route::post('statuses','StatusesController@store')->name('statuses.store')->middleware('auth');
Route::get('statuses','StatusesController@index')->name('statuses.index');

//routes likes
Route::post('statuses/{status}/likes','StatusLikesController@store')->name('statuses.likes.store');

Route::auth();

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
