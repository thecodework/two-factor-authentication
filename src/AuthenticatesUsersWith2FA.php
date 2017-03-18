<?php

namespace Thecodework\TwoFactorAuthentication;

use App\User;
use Auth;
use Illuminate\Http\Request;
use OTPHP\TOTP;
use Validator;

trait AuthenticatesUsersWith2Fa
{
    /*
     * Priveate variable to store user object.
     */
    private $user;

    /**
     * If username/password is authenticated then the authenticted.
     * If 2FA enabled it will redirect user to enter TOTP Token else
     * Logs the user in normally
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_2fa_enabled) {
            $request->session()->put('2fa:user:id', encrypt($user->id));
            Auth::logout();
            return redirect()->intended('verify-2fa');
        }
        return redirect()->intended(config('2fa-config.redirect_to'));
    }

    /**
     * Verify token and sign in the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyToken(Request $request)
    {
        # Pulling encrypted user id from session and getting user details
        $userId     = $request->session()->get('2fa:user:id');
        $this->user = User::find(decrypt($userId));

        # If token is not valid then custom validation error message will be shown.
        $messages = [
            'totp_token.valid_token' => 'Token is not valid',
        ];

        # Impllicitly adding an validation rule to check if token is valid or not.
        Validator::extendImplicit('valid_token', function ($attribute, $value, $parameters, $validator) {
            $totp = new TOTP(
                config('2fa-config.account_name'),
                $this->user->secret_key
            );
            return $value == $totp->now();
        });

        # If Validation fails, it will return the error else sign in the user.
        $validator = Validator::make($request->all(), [
            'totp_token' => 'required|digits:6|valid_token',
        ], $messages);

        if ($validator->fails()) {
            return redirect('verify-2fa')
                ->withErrors($validator)
                ->withInput();
        } else {

        }

        # Flush the session.
        $request->session()->forget('2fa:user:id');

        Auth::loginUsingId($this->user->id);
        return redirect()->intended(config('2fa-config.redirect_to'));
    }
}
