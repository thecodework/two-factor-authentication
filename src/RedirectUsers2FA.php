<?php

namespace Thecodework\TwoFactorAuthentication;

trait RedirectUsers2FA
{

    public function redirectUsers2FA()
    {
        //Will Use Laravel Default AuthenticateUsers Redirect Users if not then will use config redirection
        if (method_exists($this, 'redirectPath')) {
            return redirect()->intended($this->redirectPath());
        }
        return redirect()->intended(config('2fa-config.redirect_to'));
    }
}
