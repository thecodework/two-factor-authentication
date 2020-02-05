<?php

return [

    /*
     * Specify redirect url after when token authentication
     * is successful.
     */
    'redirect_to' => '/home',

    /*
     * Routes
     * Change the routes if your existing routes
     * conflicts with existing routes. or for
     * any customization.
     */
    'setup_2fa'   => 'setup-2fa',
    'enable_2fa'  => 'enable-2fa',
    'disable_2fa' => 'disable-2fa',

    /*
     * Account name which will be used as label to show on
     * authenticator mobile application.
     */
    'account_name' => 'Thecodework 2FA',

    /*
     * Set Guard for 2FA
     * By default the `web` guard will be used but you
     * can define any custom guard to utilize 2FA.
     */
    'guard' => 'web',

    /*
     * Currently Support 'Sha1'
     * The library works with the Google Authenticator application
     * for iPhone and Android. Google only supports SHA-1 digest algorithm,
     * 30 second period and 6 digits OTP. Other values for these parameters
     * are ignored by the Google Authenticator application.
     */
    'digest_algorithm' => 'sha1',

    /*
     * Size of Base32 encoded secret key.
     * Default 6 Works with GA and Authy.
     */
    'number_of_digits' => 6,

    /*
     * The Number of Seconds the code will be valid.
     * Default 30.
     */
    'period' => 30,

    /*
     * Explicitly Define Table name for the model.
     */
    'table' => 'users',

    /*
     * User Model
     * By Default `\App\User` Model is defined.
     */
    'model' => '\App\User',
];
