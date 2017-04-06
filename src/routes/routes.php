<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => '\Thecodework\TwoFactorAuthentication\Http\Controllers'], function () {
    Route::get('verify-2fa', 'TwoFactorAuthenticationController@verifyTwoFactorAuthentication');
    Route::post('verify-2fa', 'TwoFactorAuthenticationController@verifyToken');
    Route::get(config('2fa-config.setup_2fa'), 'TwoFactorAuthenticationController@setupTwoFactorAuthentication');
    Route::post(config('2fa-config.enable_2fa'), 'TwoFactorAuthenticationController@enableTwoFactorAuthentication');
    Route::post(config('2fa-config.disable_2fa'), 'TwoFactorAuthenticationController@disableTwoFactorAuthentication');
});
