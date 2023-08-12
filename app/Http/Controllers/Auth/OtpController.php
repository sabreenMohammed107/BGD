<?php

namespace App\Http\Controllers\Auth;

use App\Classes\MySms;
use App\Http\Controllers\Controller;
use App\Services\OtpService;
use GuzzleHttp\Client;

class OtpController extends Controller
{
    public function sendOtp(OtpService $otpService)
    {
        $phoneNumber = '201100650931'; // replace with the recipient's phone number
        $otp = mt_rand(100000, 999999); // replace with the generated OTP

        $result = $otpService->sendOtp($phoneNumber, $otp);

        if ($result) {
            // OTP sent successfully
            return response()->json(['message' => 'OTP sent successfully']);
        } else {
            // Failed to send OTP
            return response()->json(['message' => 'Failed to send OTP'], 500);
        }

       
   
    }
}