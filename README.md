[![Build Status](https://travis-ci.org/thecodework/two-factor-authentication.svg?branch=master)](https://travis-ci.org/thecodework/two-factor-authentication)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodework/two-factor-authentication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thecodework/two-factor-authentication/?branch=master)
[![StyleCI](https://styleci.io/repos/85341644/shield?branch=master)](https://styleci.io/repos/85341644)
[![License](https://poser.pugx.org/thecodework/two-factor-authentication/license)](https://packagist.org/packages/thecodework/two-factor-authentication)

# Laravel Two Factor Authentication

Two Factor Authentication is an extra security layer for your application. Two Factor authentication implements TOTP defined in [RFC 6238](https://tools.ietf.org/html/rfc6238)

## Requirements
  - PHP >= 7.0
  - Laravel >= 5.3
  - Google Authenticator [Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en) - [iOS](https://itunes.apple.com/in/app/google-authenticator/id388497605?mt=8) (Recommended) or [Authy](https://www.authy.com/) mobile app

Note: Current implementation is buggy using Authy as Google Authenticator uses SHA-1 with 128-bit keys whereas Authy uses SHA-2 with 256-bit keys. SHA-2 with 256-bit key is coming in verion `0.1.0`. But if wish to use Authy as well as Google Authenticator I'd suggest to go with default setting of `period`, `number_of_digits` and `algorithm`.

## Installation
**1. Composer Install**

```bash
$ composer require thecodework/two-factor-authentication
```

**2. Add Service Provider**

After requiring the package add `TwoFactorAuthenticationServiceProvider::class` into providors array in `app.php` confi file

```php
[
 'providers' => [
    //...
    Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider::class
  ]
]
```

**3. Publish the ConfigFile**

Publish config file
```
$ php artisan vendor:publish --provider="Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider" --tag=config
```
Once the config file is published you can navigate to config directory of your application and look for `2fa-config.php` file and change configuration as you want.

**4. Run Migrations**

Now run the migration
```bash
$ php artisan migrate
```
It will use the default User model and adds two columns `is_2fa_enabled` and `secret_key`.

**5. Add `AuthenticatesUserWith2FA` trait in the LoginController**

Now the config file is placed. The last thing to do is addding `AuthenticatesUsersWith2FA` trait in the  `Http/Controllers/Auth/LoginController.php` file which helps to stop user at verify-2fa page to enter TOTP token after each login.

The final snippet will look like this.
```php
use AuthenticatesUsers, AuthenticatesUsersWith2FA {
    AuthenticatesUsersWith2FA::authenticated insteadof AuthenticatesUsers;
}
```
Note: Don't forget to include use statement `use Thecodework\TwoFactorAuthentication\AuthenticatesUsersWith2FA` in the header.

**6. Setup 2FA for user**

  **• Enable 2FA**

Now login to the application and visit `/setup-2fa/` route, which will show a barcode which can be scanned either using Google Authenticator or Authy mobile application as described above.
Scan that code and click **Enable Two Factor Authentication**.

  **• Disable 2FA**

To disable Two Factor, visit `/setup-2fa` route, which will now show a **Disable Two Factor Authentication** button. Click to disable 2FA for your account.

**7. Testing 2FA**

Now to test 2FA, perform logout and log back in again, it will ask you to enter Token which can be obtain from the authenticator mobile application. Enter the token and you're logged in.

### Additionally
If you want to publish views, and migration as well along with config file then run
```
$ php artisan vendor:publish --provider="Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider"
```

## Contribution
Feel free to create issues, submit PRs and talk about features and enhancement through proposing issue. If you find any security consideration, instead of creating an issue send an email to [imrealashu@gmail.com](mailto:imrealashu@gmail.com).


<a href="http://s05.flagcounter.com/more/Gjy"><img src="http://s05.flagcounter.com/count2/Gjy/bg_FFFFFF/txt_000000/border_FFFFFF/columns_8/maxflags_8/viewers_3/labels_1/pageviews_0/flags_0/percent_0/" alt="Flag Counter" border="0"></a>
