<?php

namespace Thecodework\TwoFactorAuthentication\Exceptions;

class TwoFactorAuthenticationExceptions extends \Exception
{
    /**
     * Column Not Found.
     */
    public static function columnNotFound()
    {
        $table = config('2fa-config.table');

        return new static("Could not locate required column `two_factor_provisioned_uri` or `is_two_factor_enabled` in `$table` table. Make sure the migrations ran properly.");
    }
}
