<?php

/**
 * This file contains all API for version 1
 * All the API will have name `api.v1.*` with prefix link is /api/v1/*
 */

Route::group(['namespace' => 'Auth'], function () {

    // Use for refresh token or authenticate by client credentials
    Route::post('oauth/token', 'AccessTokenController@issueToken')
         ->name('oauth.token');

    // Use for login by password credentials
    Route::post('login', 'AccessTokenController@issueToken')->name('login');

    // Register new user
    Route::post('register', 'RegisterController')->name('register');

    // Logs the user out.
    Route::post('logout', 'LogoutController')->middleware('auth:api')
         ->name('logout');
});
