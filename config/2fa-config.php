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
     * Number of digits can be max 30
     * To Support Google Authenticator
     */
    'number_of_digits' => 8,
];
