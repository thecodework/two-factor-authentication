<?php

namespace Thecodework\TwoFactorAuthentication\Tests;

class TwoFactorAuthenticationTest extends BaseTestCase
{
    /**
     * Test Users count after inserting one row
     * @test
     */
    public function getUsers()
    {
        $this->assertEquals(\DB::table('users')->count(), 1);
    }

    protected function getPackageProviders($app)
    {
        return [
            'Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider',
        ];
    }
}
