<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    
   //  public function login(Request $request)
   // {
   //   $result = $this->attemptLogin($request);
   //     // //Validate the incoming request using the already included validator method
   //     // // $this->validator($request->all())->validate();
   //     //
   //     // // Initialise the 2FA class
   //     // $google2fa = app('pragmarx.google2fa');
   //     // // Save the registration data in an array
   //     // $sdata = $request->all();
   //     // $this->login($user=$this->create($sdata));
   //     //
   //     if ($result==1) return view('google2fa.login');
   //     if ($result==0) return view('auth.login');
   // }

   protected function create(array $data)
   {
       return User::create([
           'email' => $data['email'],
           'password' => Hash::make($data['password']),
       ]);
   }

   //-------------------------------------------------------------

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
