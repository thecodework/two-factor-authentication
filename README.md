[![Build Status](https://travis-ci.org/thecodework/two-factor-authentication.svg?branch=master)](https://travis-ci.org/thecodework/two-factor-authentication)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodework/two-factor-authentication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thecodework/two-factor-authentication/?branch=master)
[![StyleCI](https://styleci.io/repos/85341644/shield?branch=master)](https://styleci.io/repos/85341644)

# Laravel Two Factor Authentication

Two Factor Authentication is an extra security layer for your application. Two Factor authentication implements TOTP defined in [RFC 6238](https://tools.ietf.org/html/rfc6238)

This package lets you setup your two factor authentication for your existing laravel applicaiton within a minute.
## Requirements
  - PHP 7.0 or Up
  - Laravel 5 or Up
  - Google Authenticator [Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en) - [iOS](https://itunes.apple.com/in/app/google-authenticator/id388497605?mt=8) or [Authy](https://www.authy.com/) mobile app

## Installation
**1. Composer Install**
```bash
$ composer require thecodework/two-factor-authentication:0.1.0
```
Note: The current version of the package is beta release, so be careful before using it for production applications.

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

**3. Run Migrations**
Now run the migration
```bash
$ php artisan migrate
```
It will use the default User model and adds two columns `is_2fa_enabled` and `secret_key`.

**4. Add `AuthenticatesUserWith2FA` trait in the LoginController**
Now the config file is placed. The last thing to do is addding `AuthenticatesUsersWith2FA` trait in the  `Http/Controllers/Auth/LoginController.php` file which helps to stop user at verify-2fa page to enter TOTP token after each login.

The final snippet will look like this.
```php
use AuthenticatesUsers, AuthenticatesUsersWith2FA {
    AuthenticatesUsersWith2FA::authenticated insteadof AuthenticatesUsers;
}
```
Note: Don't forget to include use statement `use Thecodework\TwoFactorAuthentication\AuthenticatesUsersWith2FA` in the header.

**5. Publish the ConfigFile**
Finally publish config file
```
$ php artisan vendor:publish --provider="Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider" --tag=config
```
Once the config file is published you can navigate to config directory of your application and look for `2fa-config.php` file and change configuration as you want.
**6. Setup 2FA for user**

Now login to the application and visit `/setup-2fa/` route, which will show a barcode which can be scanned either using Google Authenticator or Authy mobile application as described above.
Scan that code and click **Enable Two Factor Authentication**.

Now perform logout and log back in again, it will ask you to enter Token which can be obtain from the authenticator mobile application. Enter the token and you're logged in.

### Additionally
If you want to publish views, and migration as well along with config file then run
```
$ php artisan vendor:publish --provider="Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider"
```

## Contribution
Feel free to create issues, submit PRs and talk about features and enhancement through proposing issue. If you find any security consideration, instead of creating an issue send an email to [imrealashu@gmail.com](mailto:imrealashu@gmail.com).
