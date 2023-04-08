<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\userResource;
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
            // return $this->convertErrorsToString($validator->messages());
            return $this->sendError($validator->messages());

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

            return $this->sendResponse(userResource::make($user), 'User has been registed');

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
            // return $this->convertErrorsToString($validator->messages());
            return $this->sendError($validator->messages());

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
                return $this->sendResponse(userResource::make($user), 'User login successfully.');
            } else {
                return $this->sendError('Invalid Useremail or Password!');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 'Error happens!!');
        }
    }
    public function updateUser(Request $request)
    {
        try
        {

            $user = $request->user();
            $input = [
                'name' => $request->n_id,
                'mobile' => $request->mobile,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'details_address' => $request->details_address,

            ];

            if ($user) {
                $input['password'] = bcrypt($request->password);
                $user->update($input);
                $user->accessToken = $user->createToken('MyApp')->accessToken;


                return $this->sendResponse(userResource::make($user), 'User has been updated');
            }
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage(), 'Error happens!!');
            }


    }


    public function updateUserImage(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'image' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->convertErrorsToString($validator->messages());
            }
            $user = $request->user();

            if ($user) {
                if ($request->hasFile('image')) {
                    $attach_image = $request->file('image');

                    $input['image'] = $this->UplaodImage($attach_image);
                }
                $user->update($input);

                return $this->sendResponse(userResource::make($user), 'Image User has been updated');
            }
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage(), 'Error happens!!');
            }
    }

    /* uplaud image
     */
    public function UplaodImage($file_request)
    {
        //  This is Image Info..
        $file = $file_request;
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $path = $file->getRealPath();
        $mime = $file->getMimeType();

        // Rename The Image ..
        $imageName = $name;
        $uploadPath = public_path('uploads/users');

        // Move The image..
        $file->move($uploadPath, $imageName);

        return $imageName;
    }
}
