[![Build Status](https://travis-ci.org/thecodework/two-factor-authentication.svg?branch=master)](https://travis-ci.org/thecodework/two-factor-authentication)
[![Code Climate](https://codeclimate.com/github/thecodework/laravel-two-factor-authentication.png)](https://codeclimate.com/github/thecodework/laravel-two-factor-authentication)
[![StyleCI](https://styleci.io/repos/85341644/shield?branch=master)](https://styleci.io/repos/85341644)

# Laravel Two Factor Authentication

Two Factor Authentication is an extra security layer for your application. Two Factor authentication implements TOTP defined in [RFC 6238](https://tools.ietf.org/html/rfc6238)

This package lets you setup your two factor authentication for your existing laravel applicaiton within a minute.
## Requirements
  - PHP 7.0 or Up
  - Laravel 5 or Up
  - Google Authenticator [Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en) - [iOS](https://itunes.apple.com/in/app/google-authenticator/id388497605?mt=8) or [Authy](https://www.authy.com/) mobile app

## Installation
```bash
$ composer require thecodework/two-factor-authentication:0.1.0
```
Note: The current version of the package is beta release, so be careful before using it for production applications.

After requiring the package simply run
```bash
$ php artisan migrate
```
It will use the default User model and adds two columns `is_2fa_enabled` and `secret_key`

To publish config file
```
$ php artisan vendor:publish --provider="Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider" --tag=config
```
Once the config file is published you can navigate to config directory of your application and look for `2fa-config.php` file and change configuration as you want.
The config file will look like this and have following configurable option.
```php
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
```

Now the config file is placed. The last thing you've to do is add `AuthenticatesUsersWith2FA` trait in `Http/Controllers/Auth/LoginController.php` file which helps to introduce verify-2fa page after each login.

The final snippet will look like this.
```php
use AuthenticatesUsers, AuthenticatesUsersWith2FA {
    AuthenticatesUsersWith2FA::authenticated insteadof AuthenticatesUsers;
}
```
Now login to the application and visit `setup-2fa` route, which will show a barcode which can be scanned either using Google Authenticator or Authy mobile application as described above.
Scan that code and click **Enable Two Factor Authentication**.

Now perform logout and log back in again, it will ask you to enter Token which can be obtain from the authenticator mobile application. Enter the token and you're logged in.

### Additionally
If you want to publish views, and migration as well along with config file then run
```
$ php artisan vendor:publish --provider="Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider"
```

## Contribution
Feel free to create issues, submit PRs and talk about features and enhancement through proposing issue. If you find any security consideration, instead of creating an issue send an email to [imrealashu@gmail.com](mailto:imrealashu@gmail.com).
