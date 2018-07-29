<?php
  namespace App\Http\Controllers;

  use Illuminate\Support\Facades\DB;
  use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

  class Query extends Controller{

    function __construct(){

    }

    // query toàn bộ dữ liệu từ bảng $table
    public function retrieveAll($table,$daylimit){
        $role_id = Auth::user()->role_id;
        $now = date('Y-m-d h:m:s');
        $fromdate = ($daylimit<31)?date('Y-m-d h:m:s',time()-60*60*24*$daylimit):date('0000-00-00 00:00:00');

        $result = DB::table('incident')->where('role_id',$role_id)->whereBetween('date',[$fromdate,$now])->get();
        return $result;
    }

    // lấy số lượng record
    public function getTicketCount($table,$daylimit){
      $role_id = Auth::user()->role_id;
      $now = date('Y-m-d h:m:s');
      $fromdate = ($daylimit<31)?date('Y-m-d h:m:s',time()-60*60*24*$daylimit):date('0000-00-00 00:00:00');

      $result = DB::table($table)->where('role_id',$role_id)->whereBetween('date',[$fromdate,$now])->count();
      return ($result);
    }

    // top 5 priority, return array [priority name -> occurence]
    public function getTop5Priority($daylimit){
      $role_id = Auth::user()->role_id;
      $now = date('Y-m-d h:m:s');
      $fromdate = ($daylimit<31)?date('Y-m-d h:m:s',time()-60*60*24*$daylimit):date('0000-00-00 00:00:00');

      $result = DB::table('incident')->select('priority',DB::raw('count(priority) as occurence'))
                    ->where('role_id',$role_id)->whereBetween('date',[$fromdate,$now])->groupBy('priority')->
                    orderBy('occurence','desc')->offset(0)->limit(5)->get();
      return $result;
    }

    public function getTop5Ip($daylimit){
      $role_id = Auth::user()->role_id;
      $now = date('Y-m-d h:m:s');
      $fromdate = ($daylimit<31)?date('Y-m-d h:m:s',time()-60*60*24*$daylimit):date('0000-00-00 00:00:00');

      $result = DB::table('incident_alarm')
                    ->join('incident','incident_alarm.incident_id','=','incident.id')
                    ->select('src_ips',DB::raw('count(src_ips) as count'))
                    ->where('role_id',$role_id)->whereBetween('date',[$fromdate,$now])->groupBy('src_ips')
                    ->orderBy('count','desc')->offset(0)->limit(5)->get();
      return $result;
    }


  }
?>
