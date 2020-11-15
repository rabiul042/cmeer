<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Mail\TemporeEmail;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Doctors;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Session;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;





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
    //protected $redirectTo = '/home';
    protected $redirectTo = '/my-profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function guard(){
        return Auth::guard('doctor');
    }

    public function username()
    {
        return 'email';
    }




    public function login(Request $request)
    {
       // $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
       /* if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }*/


      /*  if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }*/

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
       // $this->incrementLoginAttempts($request);

        $user = Doctors::where('email', $request->email)->where('main_password', $request->password)->first();


        if ($user) {
            Auth::guard('doctor')->loginUsingId($user->id);
            return redirect('my-profile');

            if ($user->status == '0') {
                return $this->sendFailedLoginResponse($request, 'auth.pending_status');
            } else {
                Auth::guard('doctor')->loginUsingId($user->id);
                return redirect('my-profile');
            }
        }else{
            Session::flash('message', "The BMDC No or password that you've entered doesn't match any account.");
        }

        return $this->sendFailedLoginResponse($request);
    }

}
