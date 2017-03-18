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

    'digest_algorithm' => 'sha1',
    'number_of_digits' => 8
];