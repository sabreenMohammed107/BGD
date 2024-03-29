<?php

  namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\userResource;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Validator;
class GoogleController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                // Auth::login($finduser);

                // return redirect()->intended('dashboard');
                $user->accessToken = $user->createToken('MyApp')->accessToken;
                $user_id = auth()->user()->id;
                    // $token = $request->device_token;

                    // User::find($user_id)->update(['fcm_token'=>$token]);
                return $this->sendResponse(userResource::make($user), __("langMessage.User_login_successfully"));


            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
                $newUser->accessToken = $newUser->createToken('MyApp')->accessToken;

                //send sms

                // $data['mobile'] = 201117615935;
                // $data['msg'] = 'تم التفعيل';
                // $sms = Helper::send_sms($data);
    // $user->smsResponse=$sms;

                return $this->sendResponse(userResource::make($newUser), __("langMessage.User_registed"));
            }
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage(), __("langMessage.error_happens"));
            }
        //         Auth::login($newUser);

        //         return redirect()->intended('dashboard');
        //     }

        // } catch (Exception $e) {
        //     dd($e->getMessage());
        // }
    }

    public function googleLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' =>'required',
            'email' =>'required',
        ]);

        if ($validator->fails()) {
            // return $this->convertErrorsToString($validator->messages());
            return $this->sendError($validator->messages());

        }


        try {



            // $user = Socialite::driver('google')->user();
            // $user =Socialite::driver('google')->userFromToken($request->id);


            $finduser = User::where('google_id','=', $request->id)->first();
// dd([$finduser,$request->id]);
            if($finduser){
// dd('find');
                 Auth::login($finduser);

                // return redirect()->intended('dashboard');
                $finduser->accessToken = $finduser->createToken('MyApp')->accessToken;
                $user_id = auth()->user()->id;
                    // $token = $request->device_token;

                    // User::find($user_id)->update(['fcm_token'=>$token]);

                return $this->sendResponse(userResource::make($finduser),  __("langMessage.User_login_successfully"));


            }else{

                // dd('not');

                $newUser = User::create([
                    'name' =>$request->name,
                    'email' => $request->email,
                    'google_id'=>$request->id,
                    'password' => encrypt('12345678')
                ]);
                $newUser->accessToken = $newUser->createToken('MyApp')->accessToken;


                return $this->sendResponse(userResource::make($newUser), __("langMessage.User_registed"));
            }
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage(), __("langMessage.error_happens"));
            }
    }
}
