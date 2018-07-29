<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $status = Auth::user()->name;
        $this->middleware(['auth','2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    // get info from user id
    private function getInfo($uid){
      $result = DB::table('users')->where('id',$uid)->get()->toArray();
      return $result[0];
    }

    private function getRole(){
      $result = DB::table('role')->get()->toArray();
      return $result;
    }

    private function getSysRole(){
      $result = DB::table('system_role')->get()->toArray();
      return $result;
    }

    public function index(Request $req, $uid=null)
    {
        // if user is not sysadmin
        if (!$uid){
          $id = Auth::user()->id;

          $userData = array();
          $userData['twofactor_is_on']=Auth::user()->twofactor_is_on;
          $userData['admin_granted'] = Auth::user()->admin_granted;
          $userData['targetUserID'] = '';
          return view('settings',$userData);
        }
        // if user is sysadmin
        else{
          $user = self::getInfo($uid);
          if ($user == null) return false;

          $userData = array();
          $userData['twofactor_is_on'] = $user->twofactor_is_on;
          $userData['admin_granted'] = true;
          $userData['targetUserID'] = $uid;

          return view('settings',$userData);
        }
    }

    public function showNameForm(Request $req, $uid=null){
      // not sysadmin
      if(!isset($uid)){
        $userData = array();
        $userData['id'] = Auth::user()->id;
        $userData['name'] = Auth::user()->name;
        $userData['twofactor_is_on']=Auth::user()->twofactor_is_on;
        $userData['admin_granted'] = Auth::user()->admin_granted;
        $userData['targetUserID'] = '';

        return view('changeName',$userData);
      }
      // sysadmin
      else{
        $info = self::getInfo($uid);
        $userData = array();
        $userData['id'] = $info->id;
        $userData['name'] = $info->name;
        $userData['twofactor_is_on']=$info->twofactor_is_on;
        $userData['admin_granted'] = Auth::user()->admin_granted;
        $userData['targetUserID'] = $uid;

        return view('changeName',$userData);
      }
    }

    public function changeName(Request $req){
      $name = $req->name;
      $id = $req->id;

      // if user change his/her own name
      if ($id == Auth::user()->id){
        $result = DB::table('users')->where('id',$id)->update(['name' => $name]);
        return redirect()->back()->with(['msg'=>'Name changed']);
      } else
      // if user change someone else's name, check for admin privilege
      if (Auth::user()->admin_granted == 1){
        $result = DB::table('users')->where('id',$id)->update(['name'=>$name]);
        return redirect()->back()->with(['msg'=>'Name changed']);
        // admin change user's name here
      }
      // if user change someone else's name and are not granted admin privilege
      else return redirect()->back()->with(['msg'=>'Internal error']);
    }

    public function showPasswordForm(Request $req, $uid = null){
      if(!isset($uid)){
        $userData = array();
        $userData['id'] = Auth::user()->id;
        $userData['twofactor_is_on']=Auth::user()->twofactor_is_on;
        $userData['admin_granted'] = Auth::user()->admin_granted;
        $userData['targetUserID'] = '';

        return view('changePwd',$userData);
      }
      else{
        $info = self::getInfo($uid);
        $userData = array();
        $userData['id'] = $info->id;
        $userData['twofactor_is_on']=$info->twofactor_is_on;
        $userData['admin_granted'] = Auth::user()->admin_granted;
        $userData['targetUserID'] = $uid;

        return view('changePwd',$userData);
      }
    }

    public function changePassword(Request $req){
      $id = $req->id;
      $old_password = $req->old_password;
      // $old_password = bcrypt($old_password);
      $password = $req->password;
      $cf = $req->cf_password;

      // if user change his/her own password
      if ($id == Auth::user()->id){
        $pwdCorrect = Hash::check($old_password,Auth::user()->password);
        if (!$pwdCorrect && !Auth::user()->admin_granted)
          return redirect()->back()->with(['msg'=>'Incorrect password']);

        if ($password != $cf)
          return redirect()->back()->with(['msg'=>'Confirm not match']);

        if ($old_password == $cf)
          return redirect()->back()->with(['msg'=>'Your new password cannot be the same as old password']);

        $result = DB::table('users')->where([['id',$id]])->update(['password' => bcrypt($password)]);
        if ($result)
          return redirect()->back()->with(['msg'=>'Password changed successfully']);

        return redirect()->back()->with(['msg'=>'Internal error']);
      } else
      // if user change someone else's password, check for admin privilege
      if (Auth::user()->admin_granted){
        // admin change user's password here
        // no need to check for old pwd
        if ($password != $cf)
          return redirect()->back()->with(['msg'=>'Confirm not match']);

        if ($old_password == $cf)
          return redirect()->back()->with(['msg'=>'Your new password cannot be the same as old password']);

        $result = DB::table('users')->where([['id',$id]])->update(['password' => bcrypt($password)]);
        if ($result)
          return redirect()->back()->with(['msg'=>'Password changed successfully']);

        return redirect()->back()->with(['msg'=>'Internal error']);
      }
      else return redirect()->back()->with(['msg'=>'Internal error']);

    }

    public function show2faForm(Request $req, $uid = null){
      if (!isset($uid)){
        $userData = array();
        $userData['id'] = Auth::user()->id;
        $userData['email'] = Auth::user()->email;
        $userData['name'] = Auth::user()->name;
        $userData['twofactor_is_on']=Auth::user()->twofactor_is_on;
        $userData['admin_granted'] = Auth::user()->admin_granted;
        $userData['targetUserID'] = '';

        return view('change2fa',$userData);
      }
      else{
        $info = self::getInfo($uid);
        $userData = array();
        $userData['id'] = $info->id;
        $userData['twofactor_is_on']=$info->twofactor_is_on;
        $userData['admin_granted'] = Auth::user()->admin_granted;
        $userData['targetUserID'] = $uid;

        return view('change2fa',$userData);
      }
    }


    public function customAddSecretKey(Request $req){
      $id = $req->id;

      $admin_granted = Auth::user()->admin_granted;
      // if user change his/her own 2fa
      if ($id == Auth::user()->id || $admin_granted == 1){
        $secret = $req['secret'];
        $QR_Image = $req['qr'];
        $confirm_pwd = $req['one-time-password'];

        $req->session()->flash('registration_data', session('registration_data'));

        if (strlen($confirm_pwd)==0){
          return view('google2fa.register', ['targetUserID'=>$id,'admin_granted'=>$admin_granted,'QR_Image' => $QR_Image, 'secret' => $secret,'err' => 'Incorrect OTP']);
        }
        // var_dump($confirm_pwd,$secret,$QR_Image);die();
        $google2fa = app('pragmarx.google2fa');

        $verify = $google2fa->verifyGoogle2FA($secret,$confirm_pwd);
        // return (var_dump($secret,$confirm_pwd));

        if (!$verify){
          return view('google2fa.register', ['targetUserID'=>$id,'admin_granted'=>$admin_granted,'QR_Image' => $QR_Image, 'secret' => $secret,'err' => 'Incorrect OTP']);
        } else{
          $result = DB::table('users')->where('id',$id)->update(['google2fa_secret'=>$secret,'twofactor_is_on'=>1]);
          // return (var_dump($id." , ".$result));
          if ($id == Auth::user()->id)
            return redirect('/settings/change/2fa')->with(['msg'=>'Two factor authentication turned on']);
          return redirect('/sysadmin/settings/change/2fa/'.$id)->with(['msg'=>'Two factor authentication turned on']);
        }
      }
      else return redirect()->back()->with(['msg'=>'Internal error']);
    }

    // enable 2fa
    private function customEnable2fa(Request $req){
      $id = $req->id;
      $admin_granted = Auth::user()->admin_granted;
      // if user change his/her own 2fa
      if ($id == Auth::user()->id || Auth::user()->admin_granted==1){

        $user = self::getInfo($id);

        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = $google2fa->generateSecretKey();

        $email = $user[0]->email;

        // Generate the QR image. This is the image the user will scan with their app
     // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $email,
            $google2fa_secret
          );

        return view('google2fa.register', ['targetUserID'=>$id,'admin_granted'=>$admin_granted,'QR_Image' => $QR_Image, 'secret' => $google2fa_secret,'err'=>'']);
      }
      else return redirect()->back()->with(['msg'=>'Internal error']);

    }

    public function change2fa(Request $req){
      $id = $req->id;
      $password = $req->password;

      // if user change his/her own 2fa or is admin
      if ($id == Auth::user()->id){
        $pwdCorrect = Hash::check($password,Auth::user()->password);
        if(!$pwdCorrect)
          return redirect()->back()->with(['msg'=>'Incorrect password']);

        $changeTo = $req->twofactor_status;

        if ($changeTo == null){
          $result = DB::table('users')->where('id',$id)->update(['twofactor_is_on'=>0]);
          if ($result)
            return redirect()->back()->with(['msg'=>'Two factor authentication turned off']);
          return redirect()->back()->with(['msg'=>'Internal error']);
        } else
        if ($changeTo == 'on'){
          // $result = DB::table('users')->where('id',$id)->update(['twofactor_is_on'=>1]);
          return self::customEnable2fa($req);
        }
      } else
      // if user change someone else's 2fa, check for admin privilege
      if (Auth::user()->admin_granted == 1){
        // admin change user's 2fa here
        $changeTo = $req->twofactor_status;

        if ($changeTo == null){
          $result = DB::table('users')->where('id',$id)->update(['twofactor_is_on'=>0]);
          if ($result)
            return redirect()->back()->with(['msg'=>'Two factor authentication turned off']);
          return redirect()->back()->with(['msg'=>'Internal error']);
        } else
        if ($changeTo == 'on'){
          // $result = DB::table('users')->where('id',$id)->update(['twofactor_is_on'=>1]);
          return self::customEnable2fa($req);
        }
      }
      else return redirect()->back()->with(['msg'=>'Internal error']);
  }

  public function showSysRole(Request $req, $uid = null){
    if(!isset($uid)){
      return redirect('/home');
    }
    else{
      $info = self::getInfo($uid);
      $sysRole = self::getSysRole();

      $userData = array();
      $userData['id'] = $info->id;
      $userData['twofactor_is_on']=$info->twofactor_is_on;
      $userData['admin_granted'] = Auth::user()->admin_granted;
      $userData['targetUserID'] = $uid;
      $userData['userSysRole'] = $info->sys_role;

      $userData['sysRoles'] = $sysRole;

      return view('changeSysRole',$userData);
    }
  }

  public function changeSysRole(Request $req){
    $sysRole = $req->sysRole;
    $id = $req->id;

    // if user change his/her own name
    if ($id == Auth::user()->id){
      $result = DB::table('users')->where('id',$id)->update(['sys_role' => $sysRole]);
      return redirect()->back()->with(['msg'=>'System role changed']);
    } else
    // if user change someone else's name, check for admin privilege
    if (Auth::user()->admin_granted == 1){
      $result = DB::table('users')->where('id',$id)->update(['sys_role'=>$sysRole]);
      return redirect()->back()->with(['msg'=>'System role changed']);
      // admin change user's name here
    }
    // if user change someone else's name and are not granted admin privilege
    else return redirect()->back()->with(['msg'=>'Internal error']);
  }
}
