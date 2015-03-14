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

    Route::get('/offers', [
            'uses' => 'Allegro\AllegroController@getRandomOffers',
            'as'   => 'allegro.offers'
        ]
    );

    Route::get('/preferedoffers', [
            'uses' => 'Allegro\AllegroController@getOffersWithPreference',
            'as'   => 'allegro.prefered.offers'
        ]
    );

    Route::get('/categories', [
            'uses' => 'Allegro\AllegroController@getCategories',
            'as'   => 'allegro.categories'
        ]
    );

    Route::get('/categories/{id}/offer', [
            'uses' => 'Allegro\AllegroController@getOfferFromCategory',
            'as'   => 'allegro.categories.offer'
        ]
    );

    Route::get('/categories/preferences/store', [
            'uses' => 'PreferencesController@store',
            'as'   => 'categories.preferences.store'
        ]
    );
});

Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
