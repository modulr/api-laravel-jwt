<?php

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');
    });
});
