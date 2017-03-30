<?php

namespace Thecodework\TwoFactorAuthentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Base32\Base32;
use Illuminate\Http\Request;
use OTPHP\TOTP;
use Thecodework\TwoFactorAuthentication\AuthenticatesUsersWith2FA;
use Thecodework\TwoFactorAuthentication\Contracts\TwoFactorAuthenticationInterface;

class TwoFactorAuthenticationController extends Controller implements TwoFactorAuthenticationInterface
{
    use AuthenticatesUsersWith2FA;

    /**
     * Setup two factor authentication.
     *
     * @param \Illuminate\Http\Request
     * @param \Illuminate\Http\Response
     */
    public function setupTwoFactorAuthentication(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->two_factor_secret_key = $user->two_factor_secret_key ?? $this->base32EncodedString(config('2fa-config.number_of_digits'));
        $user->update();

        $totp = new TOTP(
            config('2fa-config.account_name'),
            $user->two_factor_secret_key,
            10,
            config('2fa-config.digest_algorithm'),
            config('2fa-config.number_of_digits')
        );

        $barcode = $totp->getQrCodeUri();

        // Return Barcode image if ajax Request
        if($request->ajax())
        {
            return $barcode;
        }
        return view('2fa::setup', compact('barcode', 'user'));
    }

    /**
     * Disable 2FA.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enableTwoFactorAuthentication(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->is_two_factor_enabled = 1;
        $user->update();

        if ($request-ajax()) {
            return [
                'data' => [
                    'message' => 'success',
                    'description' => '2FA Enabled'
                ]
            ];
        }
        return redirect('home');
    }

    /**
     * Enable 2FA.
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disableTwoFactorAuthentication(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->is_two_factor_enabled = 0;
        $user->two_factor_secret_key = null;
        $user->update();

        if ($request-ajax()) {
            return [
                'data' => [
                    'message' => 'success',
                    'description' => '2FA Disabled'
                ]
            ];
        }
        return redirect('home');
    }

    /**
     * Verify Two Factor Authentication.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function verifyTwoFactorAuthentication(Request $request)
    {
        if ($request->session()->has('2fa:user:id')) {
            $secret = getenv('HMAC_SECRET');
            $signature = hash_hmac('sha256', decrypt($request->session()->get('2fa:user:id')), $secret);

            if (md5($signature) !== md5($request->signature)) {
                return redirect()->intended('login');
            }

            return view('2fa::verify');
        }

        return redirect()->back(); //shoud be configurabel
    }

    /**
     * Encode Random String to 32 Base Transfer Encoding.
     *
     * @param int $length Length of the encoded string.
     *
     * @return string
     */
    private function base32EncodedString($length = 30):
    string
    {
        return Base32::encode($this->strRandom($length));
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length
     *
     * @return string
     */
    private function strRandom($length = 30):
    string
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
