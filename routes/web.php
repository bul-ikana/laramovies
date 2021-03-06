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
    return redirect('/films');
});

Route::get('/films', 'Filmcontroller@index');
Route::get('/films/create', 'Filmcontroller@create')->name('create');
Route::get('/films/{slug}', 'Filmcontroller@show');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
