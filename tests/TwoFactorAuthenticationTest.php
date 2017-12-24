<?php

namespace Thecodework\TwoFactorAuthentication\Tests;

use Illuminate\Support\Facades\Schema;

class TwoFactorAuthenticationTest extends BaseTestCase
{
    protected $user;

    public function testUserId()
    {
        $this->user = \DB::table('users')->first();
        $this->assertEquals(1, $this->user->id);
    }

    public function testIfColumnExists()
    {
        $this->assertTrue(Schema::hasColumn(config('2fa-config.table'), 'two_factor_provisioned_uri'));
        $this->assertTrue(Schema::hasColumn(config('2fa-config.table'), 'is_two_factor_enabled'));
    }
}
