<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    ['auth:api'],
    function () {
        Route::get('/films', 'Api\FilmController@index');
        Route::post('/films', 'Api\FilmController@store');
        Route::get('/films/{slug}', 'Api\FilmController@show');
        Route::put('/films/{slug}', 'Api\FilmController@update');
        Route::delete('/films/{slug}', 'Api\FilmController@destroy');
    }
);
