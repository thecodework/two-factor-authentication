[![Code Climate](https://codeclimate.com/github/thecodework/laravel-two-factor-authentication.png)](https://codeclimate.com/github/thecodework/laravel-two-factor-authentication)

# Laravel Two Factor Authentication (WIP)

Two Factor Authentication is an extra security layer for your application. Two Factor authentication implements TOTP defined in [RFC 6238](https://tools.ietf.org/html/rfc6238)

This is a simple laravel package which lets you setup your two factor authentication in your existing applicaiton within a minute.

## Installation

```bash
$ composer require thecodework/laravel-two-factor-authentication
```

After requiring the package simply run

```bash
$ php artisan migrate
```
It will use the default User model and adds two columns `is_2fa_enabled` and `secret_key`