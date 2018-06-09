<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      // var_dump(session('is2fa'));
      // die();

        $this->middleware(['auth','2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // var_dump(session()->all());
      // die();
      if (session('is2fa') === null) return view('google2fa.index');
      return view('home');
    }
}
