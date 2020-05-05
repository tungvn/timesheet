<?php

/**
 * This file contains all API for version 1
 * All the API will have name `api.v1.*` with prefix link is /api/v1/*
 */

Route::middleware('auth:api')->group(function () {

    Route::namespace('User')->group(function () {

        Route::apiResource('user', 'UserController');
    });

    Route::namespace('Setting')->group(function () {

        Route::apiResource('setting', 'SettingController')->only([
            'index',
            'update',
        ]);
    });
});
