<?php

namespace Thecodework\TwoFactorAuthentication\Tests;

class TwoFactorAuthenticationTest extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider'
        ];
    }
}