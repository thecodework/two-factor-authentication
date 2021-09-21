<?php

namespace Thecodework\TwoFactorAuthentication\Http\Controllers;

use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;
use Thecodework\TwoFactorAuthentication\AuthenticatesUsersWith2FA;
use Thecodework\TwoFactorAuthentication\Contracts\TwoFactorAuthenticationInterface;
use Thecodework\TwoFactorAuthentication\Exceptions\TwoFactorAuthenticationExceptions;
use Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider;

class TwoFactorAuthenticationController extends Controller implements TwoFactorAuthenticationInterface
{
    use AuthenticatesUsersWith2FA;

    /**
     * User Model.
     */
    protected $TwoFAModel;

    /**
     * Assigns $usersModel Property a Model instance.
     * Set authenticated users data to $user Property.
     */
    public function __construct()
    {
        $this->TwoFAModel = TwoFactorAuthenticationServiceProvider::getTwoFAModelInstance();

        $this->middleware(function ($request, $next) {
            $this->setUser(\Auth::guard(config('2fa-config.guard'))->user());

            return $next($request);
        });
    }

    /**
     * Setup two factor authentication.
     *
     * @param \Illuminate\Http\Request
     * @param \Illuminate\Http\Response
     *
     * @throws \Thecodework\TwoFactorAuthentications\Exceptions\TwoFactorAuthenticationExceptions
     *
     * @return mixed
     */
    public function setupTwoFactorAuthentication(Request $request)
    {
        $user = $this->getUser();
        $totp = TOTP::create(
            $this->base32EncodedString(),
            config('2fa-config.period'),
            config('2fa-config.digest_algorithm'),
            config('2fa-config.number_of_digits')
        );
        $totp->setLabel(config('2fa-config.account_name'));
        $totp->setParameter('image', config('2fa-config.logo'));

        $this->updateUserWithProvisionedUri($totp->getProvisioningUri());

        $qrCode = new QrCode($totp->getProvisioningUri());
        $barcode = $qrCode->writeDataUri();

        if ($request->ajax()) {
            return $barcode;
        }

        return view('2fa::setup', compact('barcode', 'user'));
    }

    /**
     * Enable 2FA.
     *
     * @param \Illuminate\Http\Request
     *
     * @return mixed
     */
    public function enableTwoFactorAuthentication(Request $request)
    {
        $user = $this->getUser();
        $user->is_two_factor_enabled = 1;
        $user->update();

        if ($request->ajax()) {
            return [
                'data' => [
                    'message'     => 'success',
                    'description' => '2FA Enabled',
                ],
            ];
        }

        return $this->redirectUsers2FA();
    }

    /**
     * Disable 2FA.
     *
     * @param \Illuminate\Http\Request
     *
     * @return mixed
     */
    public function disableTwoFactorAuthentication(Request $request)
    {
        $user = $this->getUser();
        $user->is_two_factor_enabled = 0;
        $user->two_factor_provisioned_uri = null;
        $user->update();

        if ($request->ajax()) {
            return [
                'data' => [
                    'message'     => 'success',
                    'description' => '2FA Disabled',
                ],
            ];
        }

        return $this->redirectUsers2FA();
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

        return redirect()->back(); //shoud be configurable
    }

    /**
     * Encode Random String to 32 Base Transfer Encoding.
     *
     * @return string
     */
    private function base32EncodedString(): string
    {
        return trim(Base32::encodeUpper(random_bytes(128)), '=');
    }

    /**
     * Update User data with 2FA generated Key.
     *
     * @return void
     */
    private function updateUserWithProvisionedUri($twoFactorProvisionedUri)
    {
        $user = $this->TwoFAModel->find($this->getUser()->id);
        if (
            !Schema::hasColumn(config('2fa-config.table'), 'two_factor_provisioned_uri') ||
            !Schema::hasColumn(config('2fa-config.table'), 'is_two_factor_enabled')
        ) {
            throw TwoFactorAuthenticationExceptions::columnNotFound();
        }
        $user->two_factor_provisioned_uri = $twoFactorProvisionedUri;
        $user->update();
    }
}
