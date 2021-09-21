<?php

Route::group(['middleware' => ['web'], 'namespace' => '\Thecodework\TwoFactorAuthentication\Http\Controllers'], function () {
    Route::get(config('2fa-config.verify_2fa'), 'TwoFactorAuthenticationController@verifyTwoFactorAuthentication');
    Route::post(config('2fa-config.verify_2fa_post'), 'TwoFactorAuthenticationController@verifyToken');
    Route::get(config('2fa-config.setup_2fa'), 'TwoFactorAuthenticationController@setupTwoFactorAuthentication');
    Route::post(config('2fa-config.enable_2fa'), 'TwoFactorAuthenticationController@enableTwoFactorAuthentication');
    Route::post(config('2fa-config.disable_2fa'), 'TwoFactorAuthenticationController@disableTwoFactorAuthentication');
});
