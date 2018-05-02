<?php

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/signup', 'AuthController@signup');
    Route::post('/signin', 'AuthController@signin');

    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('/signout', 'AuthController@signout');
        Route::get('/user', 'AuthController@user');
    });
});
