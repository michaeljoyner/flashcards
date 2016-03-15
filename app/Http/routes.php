<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['middleware' => ['web']], function () {

    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');

    Route::group(['middleware' => 'auth'], function() {
        Route::get('/', 'PagesController@index');
        Route::get('api/words', 'WordsController@index');
        Route::get('logout', 'Auth\AuthController@logout');
    });

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

});
