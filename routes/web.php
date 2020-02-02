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

Route::get('/movies', 'MovieController@index');
Route::get('/movies/create', 'MovieController@create');
Route::post('/movies', 'MovieController@store');
Route::get('/movies/{movie}', 'MovieController@show');
Route::get('/movies/{movie}/edit', 'MovieController@edit');
Route::patch('/movies/{movie}', 'MovieController@update');
Route::delete('/movies/{movie}', 'MovieController@destroy');

Route::get('/search', 'MovieController@search');
