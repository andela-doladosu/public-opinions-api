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

Route::middleware(['auth:api'])->group(function () {
    Route::resource('opinions', 'OpinionController')
        ->except(['index', 'show']);

    Route::delete('/users/{id}', 'UserController@delete');
    Route::post('/users/logout', 'Auth\LoginController@logout');
    Route::post('/opinions/{id}/comments', 'OpinionController@storeComment');
});

Route::post('/users/create', 'Auth\RegisterController@register');

Route::get('/opinions', 'OpinionController@index');
Route::get('/opinions/{id}', 'OpinionController@show');
