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
Route::post('statuses/{status}/likes','StatusLikesController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes','StatusLikesController@destroy')->name('statuses.likes.destroy')->middleware('auth');

//comentarios
Route::post('statuses/{status}/comments','StatusCommentsController@store')->name('statuses.comments.store')->middleware('auth');

//comments likes
Route::post('comments/{comment}/likes','CommentLikesController@store')->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes','CommentLikesController@destroy')->name('comments.likes.destroy')->middleware('auth');
Route::auth();

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
