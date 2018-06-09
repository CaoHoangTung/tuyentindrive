<?php

  class User{
    static public $attr = array(
                'userid' => '',
                'username' => '',
                'password' => '',
                'auth' => '', // quyền được input từ bên ngoài vào
              );
    static private $auth; // quyền của user hiện tại

    function __construct(){

    }

    public function Auth(){
      return self::$auth;
    }

    // kiem tra loc input doc hai
    private function validate($params){
      $username = isset($params['username'])?$params['username']:'#';
      return (isset($_COOKIE['ls']) || ((gettype($params) == 'array') && isset($params['username']) && isset($params['password']) && preg_match('/^[a-zA-Z0-9_.@-]*$/',$username)));
    }

    //truc tiep add vao db
    // params la array gom cac truong username,password,auth
    private function add($params){
      include('modules/connect.php');
      $sql = $conn->prepare("INSERT INTO users (username, password, auth) VALUES (?, ?, ?)");
      $sql->bind_param("ssi",$username,$password,$auth);

      $username = $params['username'];
      $password = md5($params['password']);
      $auth = isset($params['auth'])?$params['auth']:0;
      $err = "OK";
      if (!$sql->execute()){
        $err = $conn->error;
        $cmp = "duplicate";
        if (strrpos($err,$cmp) === false){
          $err = "err_duplicate";
        }
        else $err = "err_unknown";
      };
      include('modules/disconnect.php');
      return $err;
    }

    // validate va insert user moi database
    public function register($params){
      // validate
      if (self::validate($params)){
        //insert
        return self::add($params);
      }
      else{
        return "err_input_not_right";
      }
    }

    static public $cookie;

    // tao login token tu username va password
    private function createToken($params,$userid){
      include('modules/connect.php');
      $username = $params['username'];
      $password = md5($params['password']);
      $token = md5($username.$password);
      $sql = $conn->prepare("UPDATE users SET token = '$token' WHERE user_id = ?");
      $sql->bind_param("i",$id);
      $id = $userid;

      $res = $sql->execute();
      include('modules/disconnect.php');
      return ($res?$token:0);
    }

    // thu login
    private function attemptLogin($params){
      include('modules/connect.php');
      $username = $params['username'];
      $password = md5($params['password']);
      $sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password' LIMIT 1";

      $result = mysqli_query($conn,$sql);
      if ($result->num_rows){
          $obj = mysqli_fetch_array($result);
          $userid = $obj['user_id'];

          $loginToken = self::createToken($params,$userid);

          // create session
          session_start();
          $_SESSION['id'] = $userid;

          // create cookie
          setcookie('ls',$loginToken,(86400 * 30));
          }
      return $result->num_rows;
      }

    // true neu login thanh cong
    // params la mot array voi truong bat buoc la username va password
    public function login($params){
      if ((isset($_COOKIE['ls']) && (self::validate($_COOKIE['ls'])))) {
        $token = $_COOKIE['ls'];
        $sql = "SELECT * FROM `users` WHERE token = '$token' LIMIT 1";
        $result = mysqli_query($conn,$sql);

        return $result->num_rows;
      }
      if (self::validate($params)){
        return self::attemptLogin($params);
      }
      return 0;
    }

    public function logout(){
      session_destroy();
      if (isset($_SERVER['HTTP_COOKIE'])) {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach($cookies as $cookie) {
          $parts = explode('=', $cookie);
          $name = trim($parts[0]);
          setcookie($name, '', time()-1000);
          setcookie($name, '', time()-1000, '/');
      }
}
    }

  }
?>﻿
