<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\ForgotRequest;
use App\Http\Resources\userResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    return response([
        'message'=>'check your email'
    ]);

}catch(\Exception $ex){
return response([
    'message'=>$ex->getMessage()
],status:400);
}


}
}
