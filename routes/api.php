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

    Route::middleware('auth:api')->group(function () {

        Route::prefix('users')->name('users.')->group(function () {

            Route::get('/', 'UserController@index')->name('index');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('{user}', 'UserController@show')->name('show');
            Route::put('{user}', 'UserController@update')->name('update');
            Route::delete('{user}', 'UserController@destroy')->name('destroy');

            Route::prefix('roles')->name('roles.')->group(function () {

                Route::patch('{user}/assign', 'UserController@assignRole')->name('assign');
                Route::patch('{user}/remove', 'UserController@removeRole')->name('remove');
            });
        });

        Route::prefix('skus')->name('sku.')->group(function() {

            Route::get('/', 'SKUController@index')->name('index');
            Route::post('/', 'SKUController@store')->name('store');
            Route::get('{sku}', 'SKUController@show')->name('show');
            Route::put('{sku}', 'SKUController@update')->name('update');
            Route::delete('{sku}', 'SKUController@destroy')->name('destroy');
        });
    });
});
