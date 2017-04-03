<?php

return [

    /*
     * Specify redirect url after when token authentication
     * is successfull.
     */
    'redirect_to' => '/home',

    /*
     * Account name which will be used as label to show on
     * authenticator mobile application.
     */
    'account_name' => 'Thecodework 2FA',

    /*
     * Currntly Support 'Sha1'
     * The library works with the Google Authenticator application
     * for iPhone and Android. Google only supports SHA-1 digest algorithm,
     * 30 second period and 6 digits OTP. Other values for these parameters
     * are ignored by the Google Authenticator application.
     */
    'digest_algorithm' => 'sha1',

    /*
     * Size of Base32 encoded secret key.
     * Default 10.
     * Note. Keeping Secret key in multiple of
     * 5 would result secret key not padded
     * with equal to symbols.
     */
    'number_of_digits' => 10,

    /*
     * Explitcitly Define Table name for the model.
     */
    'table' => 'users',

    /*
     * User Model
     * By Default `\App\User` Model is defined.
     */
    'model' => '\App\User',
];
