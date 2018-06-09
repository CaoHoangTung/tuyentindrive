<?php
namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class tfaController extends Controller
{
    public function authenticate(Request $request)
   {
      $obj = $request->all();
      $sess = session('data');
      $secret_token = $sess['secret'];

      $input_token = $obj['one_time_password'];
      $google2fa = app('pragmarx.google2fa');
      // die($secret_token." ; ".$input_token);
      $res = $google2fa->verifyKey($secret_token,$input_token);

      if ($res) {
        session(['is2fa' => '1']);
      }
      return redirect('home');
   }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

}
