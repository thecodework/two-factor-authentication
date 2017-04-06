<?php

namespace Thecodework\TwoFactorAuthentication\Tests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Thecodework\TwoFactorAuthentication\Http\Controllers\TwoFactorAuthenticationController;

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
        $this->assertTrue(Schema::hasColumn(config('2fa-config.table'), 'two_factor_secret_key'));
        $this->assertTrue(Schema::hasColumn(config('2fa-config.table'), 'is_two_factor_enabled'));
    }

}
