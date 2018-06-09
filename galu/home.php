<?php

	// NHẬN CÁC POST REQUEST Ở ĐÂY, GỌI SANG OBJECT VÀ MODULES ĐỂ XỬ LÍ

	// include object user
	include('object/user.php');

	// include module connect db
	include('modules/connect.php');

	die("HEHE");


	// Nếu không gọi home.php để thao tác với dữ liệu
	// khi người dùng truy cập homepage
	$user = new User();

	if ($user::login($user::$attr)){
		include('modules/disconnect.php');
		header('Location: /public/index.php');
		die();
	}
	else{
		include('modules/disconnect.php');
		header('Location: /public/login.php');
		die();
	}
?>
