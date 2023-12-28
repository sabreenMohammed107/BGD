<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Http\Resources\userResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Str;
class ForgotController extends BaseController
{
public function forgot(ForgotRequest $request){
$email=$request->input(key:'email');
$user = User::where('email',$email);
if($user->doesntExist()){
    return response([
        'status'=>false,
        'message'=> __("langMessage.user_not_exist"),

    ]);
}

// $token=Str::random(length:5);
$token=mt_rand(100000, 999999);
try{
    DB::table('password_resets')->insert([
        'email'=>$email,
        'token'=>$token
    ]);
    //send Email
    $plainTextContent = __("langMessage.dear") . " " . $user->first()->name . ",\n\n" . __("langMessage.before") . "\n\n" . $token . "\n\n" . __("langMessage.after") . "\n\n" . __("langMessage.thanks") . "\n" . __("langMessage.regards") . "\n";

    Mail::raw($plainTextContent, function($message) use ($email) {
        $message->to($email);
        $message->subject('Reset Password');
    });
    // Mail::send([], [], function($message) use ($email, $plainTextContent) {
    //     $message->to($email);
    //     $message->subject('Subject');
    //     $message->setBody($plainTextContent, 'text/plain');
    // });

    // Mail::send('emails.forgot', [
    //     'token' => $token, 
    //     'dear' => __("langMessage.dear"),
    //     'name' => $user->first()->name,
    //     'before' => __("langMessage.before"),
    //     'after' => __("langMessage.after"),
    //     'thanks' => __("langMessage.thanks"),
    //     'regards' => __("langMessage.regards"),
    // ], function($message) use($email){
    //     $message->to($email);
    //     $message->subject('Reset Password');
    // });

    return response([
        'status'=>true,
        'message'=>__("langMessage.check_email")
    ]);

}catch(\Exception $ex){
return response([
    'status'=>false,
    'message'=>$ex->getMessage()
]);
}


}

public function reset(ResetRequest $request){
$token=$request->input(key:'token');
if(!$passwordResets=DB::table(table:'password_resets')->where('token',$token)->first()){
return response([
    'status'=>false,
    'message'=> __("langMessage.invalid_token")
]);
}
if(!$user=User::where('email',$passwordResets->email)->first()){
    return response([
        'status'=>false,
        'message'=> __("langMessage.user_not_exist")
    ]);
}
$user->password=Hash::make($request->input(key:'password'));
$user->save();
return response([
    'status'=>true,
    'message'=> __("langMessage.success")
]);
}
}
