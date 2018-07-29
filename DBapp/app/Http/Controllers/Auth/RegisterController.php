<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

// added
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
    // change the name of the name of the trait's method in this class
    // so it does not clash with our own register method
       register as registration;
   }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function register(Request $request){
       //Validate the incoming request using the already included validator method
       $this->validator($request->all())->validate();

       // Initialise the 2FA class
       $google2fa = app('pragmarx.google2fa');

       // Save the registration data in an array
       $registration_data = $request->all();

       // register the user
       return $this->registration($request);

       // Add the secret key to the registration data
       $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();

       // Save the registration data to the user session for just the next request
       $request->session()->flash('registration_data', $registration_data);

       // Generate the QR image. This is the image the user will scan with their app
    // to set up two factor authentication
       $QR_Image = $google2fa->getQRCodeInline(
           config('app.name'),
           $registration_data['email'],
           $registration_data['google2fa_secret']
       );


       // Pass the QR barcode image to our view
       return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret'],'err'=>'']);
   }

   public function completeRegistration(Request $request)
    {
        $secret = $request['secret'];
        $QR_Image = $request['qr'];
        $confirm_pwd = $request['one-time-password'];
        $request->session()->flash('registration_data', session('registration_data'));
        if (strlen($confirm_pwd)==0){
          return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $secret,'err' => 'Không khớp']);
        }
        // var_dump($confirm_pwd,$secret,$QR_Image);die();
        $google2fa = app('pragmarx.google2fa');
        $verify = $google2fa->verifyGoogle2FA($secret,$confirm_pwd);
        // return (var_dump($verify));

        if (!$verify){
          return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $secret,'err' => 'Không khớp']);
        }


        $registration_data = session('registration_data');
        $registration_data['one_time_password'] = $confirm_pwd;
        $request->session()->flash('registration_data',$registration_data);

        // add the session data back to the request input
        $request->merge(session('registration_data'));

        // Call the default laravel authentication
        return $this->registration($request);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      return User::create([
             'name' => $data['name'],
             'email' => $data['email'],
             'password' => bcrypt($data['password']),
             // 'google2fa_secret' => $data['google2fa_secret'],
             'role_id' => $data['role_id'],
      ]);
    }
}
