<?php

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

Route::group(["middleware" => "auth:api"], function () {
    Route::get('/me', 'Api\UsersController@me')->name('api.me');
    Route::post('/change-password', 'Api\UsersController@changePassword')->name('api.change-password');
    Route::post('/change-details', 'Api\UsersController@changeDetails')->name('api.change-details');
});

Route::post('/login', 'Api\AuthController@login')->name('api.login');
Route::post('/register', 'Api\AuthController@register')->name('api.register');
Route::get('/authorize/{provider}/redirect', 'Api\SocialAuthController@redirectToProvider')->name('api.social.redirect');
Route::get('/authorize/{provider}/callback', 'Api\SocialAuthController@handleProviderCallback')->name('api.social.callback');
Route::get('/email-verification', 'Api\VerificationController@verify')->name('verification.verify');

Route::post('/forgot-password', 'Api\ForgotPasswordController@sendResetLinkEmail')->name('api.forgot-password');
Route::post('/reset-password', 'Api\ResetPasswordController@reset')->name('api.reset-password');

Route::get('/constants', 'Api\ConstantsController@index')->name('api.constants');
