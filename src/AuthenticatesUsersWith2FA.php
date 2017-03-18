<?php

namespace Thecodework\TwoFactorAuthentication;

use App\User;
use Auth;
use Illuminate\Http\Request;
use OTPHP\TOTP;
use Validator;

trait AuthenticatesUsersWith2Fa
{
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_2fa_enabled) {
            $request->session()->put('2fa:user:id', encrypt($user->id));
            Auth::logout();
            return redirect()->intended('verify-2fa');
        }
        return redirect()->intended(config('2fa-config.redirect_to'));
    }
    public function verifyToken(Request $request)
    {
        $userId = $request->session()->get('2fa:user:id');
        $user = User::find(decrypt($userId));

        $validator = Validator::make($request->all(), [
            'totp_token' => 'required|digits:6',
        ]);
        if ($validator->fails()) {
            return redirect('verify-2fa')
                ->withErrors($validator)
                ->withInput();
        }

        $totp = new TOTP(
            config('2fa-config.account_name'),
            $user->secret_key
        );

        if ($totp->now() === $request->totp_token) {
            Auth::loginUsingId($user->id);
            return redirect()->intended(config('2fa-config.redirect_to'));
        } else {

        }
    }
}
