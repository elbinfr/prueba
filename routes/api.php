<?php

use Illuminate\Http\Request;

Route::resource('user', 'UserController');

/*
Route::post('login', 'AuthController@login')->name('login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('logout', 'AuthController@logout');
    Route::resource('user', 'UserController');
});
*/
