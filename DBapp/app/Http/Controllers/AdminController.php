<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {

        $limit = isset($req['limit'])?$req['limit']:1;

        $query = new Query();
        $totalTicket = $query->getTicketCount('incident',$limit);
        $tickets = $query->retrieveAll('incident',$limit);
        $priorities = $query->getTop5Priority($limit);
        $ips = $query->getTop5Ip($limit);

        $uid = Auth::user()->id;
        $user = DB::table('users')->where('id',$uid)->get()->toArray();
        $admin_granted = $user[0]->admin_granted;

        $arr = array();

        $arr['totalTicket'] = $totalTicket;
        $arr['tickets'] = $tickets;
        $arr['priorities'] = $priorities;
        $arr['ips'] = $ips;
        $arr['color'] = ["blue", "green", "purple", "aero", "red"];
        $arr['daylimit'] = $limit;

        $arr['admin_granted'] = $admin_granted;
        return view('admin',$arr);
    }
}
