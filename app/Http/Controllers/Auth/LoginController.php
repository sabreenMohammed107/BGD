<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
       $this->middleware('guest:doctor')->except('logout');
    }

    public function showAdminLoginForm()
    {


        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $request->session()->flush();

        $request->session()->regenerate();
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('email', 'remember'));
    }


    public function showDoctorLoginForm()
    {

        return view('auth.login', ['url' => 'doctor']);
    }

    public function doctorLogin(Request $request)
    {
        $request->session()->flush();

        $request->session()->regenerate();

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/doctor');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {

        if (Auth::guard('admin')->check()) {
        //   $guard = 'admin';
          $this->guard()->logout();
          $request->session()->flush();

          $request->session()->regenerate();
          return redirect()->guest('/login/admin');
        }
        if (Auth::guard('doctor')->check()) {
            $guard = 'doctor';
            $this->guard()->logout();
            $request->session()->flush();

            $request->session()->regenerate();
            return redirect()->guest('/login/doctor');
          }

          $this->guard()->logout();
          $request->session()->flush();

          $request->session()->regenerate();
          return redirect()->guest('/login');
    }
}
