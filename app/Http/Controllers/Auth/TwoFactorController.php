<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use BaconQrCode\Encoder\QrCode as EncoderQrCode;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Endroid\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;


class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Hiển thị mã QR để người dùng scan
     */
    public function showQRCode(Request $request)
    {
        $user = $request->user();

        if (!$user->google2fa_secret) {
            $user->google2fa_secret = $this->google2fa->generateSecretKey();
            $user->save();
        }

        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        return response()->json([
            'qr' => $qrCodeUrl,
            'secret' => $user->google2fa_secret,
        ]);
    }

    /**
     * Xác minh mã OTP từ Google Authenticator
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = $request->user();

        $isValid = $this->google2fa->verifyKey($user->google2fa_secret, $request->otp);

        if (!$isValid) {
            return response()->json([
                'message' => 'Mã OTP không hợp lệ',
            ], 422);
        }

        $user->is_2fa_verified = true;
        $user->save();

        return response()->json([
            'message' => 'Xác thực 2FA thành công',
        ]);
    }   
}
