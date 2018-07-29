<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SysAdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $status = Auth::user()->name;
        $this->middleware(['auth','2fa','sysadmin']);
    }

    public function index(){
      $users = DB::table('users')->get()->toArray();
      $str = "";
      return view('superuser.index',['users'=>$users,'admin_granted'=>1]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

}
