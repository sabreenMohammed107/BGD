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
if(User::where('email',$email)->doesntExist()){
    return response([
        'message'=>'user doen\'t exsists !',

    ],status:404);
}
$token=Str::random(length:10);
try{
    DB::table('password_resets')->insert([
        'email'=>$email,
        'token'=>$token
    ]);
    //send Email
    Mail::send('emails.forgot', ['token' => $token], function($message) use($email){
        $message->to($email);
        $message->subject('Reset Password');
    });

    return response([
        'message'=>'check your email'
    ]);

}catch(\Exception $ex){
return response([
    'message'=>$ex->getMessage()
],status:400);
}


}

public function reset(ResetRequest $request){
$token=$request->input(key:'token');
if(!$passwordResets=DB::table(table:'password_resets')->where('token',$token)->first()){
return response([
    'message'=>'invalid token'
],status:400);
}
if(!$user=User::where('email',$passwordResets->email)->first()){
    return response([
        'message'=>'user not exist '
    ],status:404);
}
$user->password=Hash::make($request->input(key:'password'));
$user->save();
return response([
    'message'=>'success'
]);
}
}
