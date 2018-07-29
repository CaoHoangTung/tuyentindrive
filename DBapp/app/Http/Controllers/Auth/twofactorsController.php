<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class twofactorsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }


    function AuthLogin(Request $request) {
      $request->session()->flash('registration_data', session('registration_data'));
       // return redirect(URL()->previous());
       return redirect('home');
    }
}
