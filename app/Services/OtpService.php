<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Support\Facades\App;
class OtpService
{
    protected $apiUrl ="https://api.smsgatewayapi.com/v1/message/send";


    public function sendOtp($phoneNumber, $otp){

        $ch = curl_init('https://gateway.seven.io/api/sms');
        if(App::getLocale()=="en"){
        $data = [
            'to' => $phoneNumber, //Receiver (required)
            'text' => "Please use OTP'. $otp .'  to complete your registeration", //Message (required)
            'from' => 'BDG App' //Sender (required)
        ];
    }else{
        $data = [
            'to' => $phoneNumber, //Receiver (required)
            'text' => "Bitte verwenden Sie den '. $otp .', um Ihre Registrierung abzuschließen.", //Message (required)
            'from' => 'BDG App' //Sender (required)
        ];
    }
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        //   'to' => '4917612121212,Peter,FriendsGroup',
        //   'text' => 'Hello, this is a test SMS',
        //   'from' => 'sender'
        // ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-type: application/json',
          'X-Api-Key: kWcGOYaiUXk0g2BmnJgGVw1OXvCVgbCMDUJh1fzS0JMyoHsdx35eYfJaHRGtT6DD'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // var_dump($result);
        $response = curl_exec($ch);

        $user=User::where('mobile',$phoneNumber)->first();
        $user->update(['otp'=>$otp]);
        curl_close($ch);
        return $response;
    }

    public function sendOtpOld($phoneNumber, $otp)
    {
        $ch = curl_init();
        $client_id = env("OTP_Client_ID"); // Your API client ID (required)
        $client_secret = env("OTP_Client_SECRET"); // Your API client secret (required)

        // $client_id = "983428922389235212547"; // Your API client ID (required)
        // $client_secret = "6GNr6kyfrQ5GpdNtjVgmD"; // Your API client secret (required)

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
