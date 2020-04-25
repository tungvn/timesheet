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

Route::middleware('auth:api')->group(function () {

    Route::apiResource('user', 'User\UserController');

    Route::namespace('Me')->group(function () {

        Route::prefix('me')->name('me.')->group(function () {

            Route::apiResource('timesheet', 'Timesheet\UserTimesheetController');

            Route::patch('password', 'ChangePasswordController')
                ->name('change-password');
        });

        Route::get('me', 'MeController@show')->name('me.show');

        Route::patch('me', 'MeController@update')->name('me.update');
    });

    Route::namespace('Timesheet')->group(function () {

        Route::patch('timesheet/{timesheet}/approve', 'ApproveController')
            ->name('timesheet.approve');

        Route::apiResource('timesheet', 'TimesheetController')->only([
            'index',
            'show',
            'destroy',
        ]);
    });

    Route::namespace('Setting')->group(function () {

        Route::apiResource('setting', 'SettingController')->only([
            'index',
            'update',
        ]);
    });
});
