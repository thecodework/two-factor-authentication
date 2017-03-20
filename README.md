[![Code Climate](https://codeclimate.com/github/thecodework/laravel-two-factor-authentication.png)](https://codeclimate.com/github/thecodework/laravel-two-factor-authentication)
[![StyleCI](https://styleci.io/repos/85341644/shield?branch=master)](https://styleci.io/repos/85341644)

# Laravel Two Factor Authentication (WIP)

Two Factor Authentication is an extra security layer for your application. Two Factor authentication implements TOTP defined in [RFC 6238](https://tools.ietf.org/html/rfc6238)

This is a simple laravel package which lets you setup your two factor authentication in your existing applicaiton within a minute.
## Requirements
  - PHP 7.0 or Up
  - Laravel 5 or Up
  - Google Authenticator [Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en) - [iOS](https://itunes.apple.com/in/app/google-authenticator/id388497605?mt=8) or [Authy](https://www.authy.com/) mobile app

## Installation

```bash
$ composer require thecodework/laravel-two-factor-authentication
```

After requiring the package simply run

```bash
$ php artisan migrate
```
It will use the default User model and adds two columns `is_2fa_enabled` and `secret_key`
