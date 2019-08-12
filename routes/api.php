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

Route::namespace('v1')->group(function () {

    // start of v1 namespace
    Route::middleware('auth:api')->group(function () {

        // start of api:auth middleware
        Route::prefix('users')->name('users.')->group(function () {

            // start of users prefix
            Route::get('/', 'UserController@index')->name('index');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('{user}', 'UserController@show')->name('show');
            Route::put('{user}', 'UserController@update')->name('update');
            Route::delete('{user}', 'UserController@destroy')->name('destroy');
            // end of users prefix
        });
        // end of api:auth middleware
    });
    // end of v1 namespace
});
