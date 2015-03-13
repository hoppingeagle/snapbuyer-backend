<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::group(['prefix' => 'allegro'], function () {

    Route::get('/list', [
        'uses' => 'Allegro\AllegroController@index',
        'as'   => 'allegro.list'
    ]);

    Route::get('/token', [
        'uses' => 'Allegro\AllegroController@getAuthorizationToken',
        'as'   => 'allegro.token'
    ]);
});

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
