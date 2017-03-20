<?php

namespace Thecodework\TwoFactorAuthentication\Contracts;

use Illuminate\Http\Request;

interface TwoFactorAuthenticationInterface
{
    public function setupTwoFactorAuthentication(Request $request);

    public function enableTwoFactorAuthentication(Request $request);

    public function verifyTwoFactorAuthentication(Request $request);
}
