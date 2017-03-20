<?php

Route::group(['middleware' => ['web'], 'namespace' => '\Thecodework\TwoFactorAuthentication\Http\Controllers'], function () {
    Route::get('verify-2fa', 'TwoFactorAuthenticationController@verifyTwoFactorAuthentication');
    Route::post('verify-2fa', 'TwoFactorAuthenticationController@verifyToken');
    Route::get('setup-2fa', 'TwoFactorAuthenticationController@setupTwoFactorAuthentication');
    Route::post('enable-2fa', 'TwoFactorAuthenticationController@enableTwoFactorAuthentication');
});
