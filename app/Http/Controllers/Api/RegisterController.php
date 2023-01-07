<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            // $input['user_type'] = 1;
            $user = User::create($input);
            $user->accessToken = $user->createToken('MyApp')->accessToken;

            //send sms

            // $data['mobile'] = 201117615935;
            // $data['msg'] = 'تم التفعيل';
            // $sms = Helper::send_sms($data);
// $user->smsResponse=$sms;

            return $this->sendResponse($user, 'User has been registed');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Error happens!!');
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            // 'device_token' =>'required',
        ]);

        if ($validator->fails()) {
            return $this->convertErrorsToString($validator->messages());
        }

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $user->accessToken = $user->createToken('MyApp')->accessToken;
                //devices
// $device = Device::where('token','=', $request->device_token)->first(); //laravel returns an integer
// $data=[
//     'token'=> $request->device_token,
//     'user_id'=>$user->id,
//     'status'=>1,
// ];
// if($device) {
//     $device->update($data);

                // } else {
//     Device::create($data);
// }
                return $this->sendResponse($user, 'User login successfully.');
            } else {
                return $this->sendError('Invalid Useremail or Password!');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Error happens!!');
        }
    }

}
