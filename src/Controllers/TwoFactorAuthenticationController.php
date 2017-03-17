<?php

namespace Thecodework\TwoFactorAuthentication\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Base32\Base32;
use Illuminate\Http\Request;
use OTPHP\TOTP;
use Thecodework\TwoFactorAuthentication\AuthenticatesUsersWith2FA;

class TwoFactorAuthenticationController extends Controller
{
    use AuthenticatesUsersWith2FA;


    public function setupTwoFactorAuthentication(Request $request)
    {
        $secret_key = $this->base32EncodedString();
        $user = User::find($request->user()->id);
        $user->secret_key = $secret_key;
        $user->update();
        $totp = new TOTP(
            config('2fa-config.account_name'),
            $secret_key
        );

        $barcode = $totp->getQrCodeUri();
        return view('2fa::setup',compact('barcode'));
    }
    public function enableTwoFactorAuthentication(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->is_2fa_enabled = 1;
        $user->update();
        return redirect('home');
    }

    public function verifyTwoFactorAuthentication(Request $request)
    {
        if ($request->session()->has('2fa:user:id')) {
            return view('2fa::verify');
        }
        return redirect()->back(); //shoud be configurabel
    }

    /**
     * Encode Random String to 32 Base Transfer Encoding
     *
     * @param int $length Length of the encoded string.
     * @return void
     */
    private function base32EncodedString($length = 30)
    {
         return Base32::encode($this->str_random($length));
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */
    private function str_random($length = 30)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

}
