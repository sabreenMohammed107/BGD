<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\User;

class OtpService
{
    protected $apiUrl ="https://api.smsgatewayapi.com/v1/message/send";

    public function sendOtp($phoneNumber, $otp)
    {
        $ch = curl_init();
        $client_id = env("OTP_Client_ID"); // Your API client ID (required)
        $client_secret = env("OTP_Client_SECRET"); // Your API client secret (required)
        $data = [
            'message' => $otp, //Message (required)
            'to' => $phoneNumber, //Receiver (required)
            'sender' => "Sabreen" //Sender (required)
        ];
        curl_setopt($ch, CURLOPT_URL, "$this->apiUrl");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Client-Id: $client_id",
            "X-Client-Secret: $client_secret",
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);

        $user=User::where('mobile',$phoneNumber)->first();
        dd($user);
        $user->update(['otp'=>$otp]);
        return $response;
    }

    public function checkOtp($email, $otp)
    {
        $user=User::where('email',$email)->first();
        if($user->otp == $otp){
            return true;
        }
        else{
            return false;
        }
    }
}
