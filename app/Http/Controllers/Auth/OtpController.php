<?php

namespace App\Http\Controllers\Auth;

use App\Classes\MySms;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Services\OtpService;
use GuzzleHttp\Client;
use App\Http\Requests\CheckOtpRequest;
use App\Http\Requests\ResendOtpRequest;
class OtpController extends BaseController
{
    public function sendOtp(OtpService $otpService)
    {
        $phoneNumber = '201117615935'; // replace with the recipient's phone number
        $otp = mt_rand(100000, 999999); // replace with the generated OTP

        $result = $otpService->sendOtp($phoneNumber, $otp);

        if ($result) {
            // OTP sent successfully
            // return response()->json(['message' => 'OTP sent successfully']);
            return $this->sendResponse(null, __("OTP sent successfully"));
        } else {
            // Failed to send OTP
            // return response()->json(['message' => 'Failed to send OTP'], 500);
            return $this->sendError('Failed to send OTP');
        }



    }
    public function checkOtp(OtpService $otpService, CheckOtpRequest $request){
        $result = $otpService->checkOtp($request->email,$request->otp);

    if ($result) {
        // OTP sent successfully
        // return response()->json(['message' => 'Exist OTP'],200);
        return $this->sendResponse(null, __("Exist OTP"));
    } else {
        // Failed to send OTP
        // return response()->json(['message' => 'Invalid OTP'], 401);
        return $this->sendError('Invalid OTP');
    }
  }

  public function resendOtp(OtpService $otpService,ResendOtpRequest $request)
    {

        $otp = mt_rand(100000, 999999);
        $result = $otpService->sendOtp($request->mobile, $otp);

        if ($result) {
            // OTP sent successfully
            // return response()->json(['message' => 'OTP Resent successfully']);
            return $this->sendResponse(null, __("OTP Resent successfully"));
        } else {
            // Failed to send OTP
            // return response()->json(['message' => 'Failed to Resend OTP'], 500);
            return $this->sendError('Failed to Resend OTP');
        }



    }
}
