<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="css/login_style.css">
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

</head>

<body>

<h2>Quản lí kế toán</h2>

  <div class="imgcontainer">
    <h2>GALU</h2>
  </div>

  <div class="container">
    <label for="uname"><b>Tên đăng nhập</b></label>
    <input type="text" placeholder="Tên đăng nhập" id="usn" name="username" required>

    <label for="psw"><b>Mật khẩu</b></label>
    <input type="password" placeholder="Mật khẩu" id="pwd" name="password" required>

    <button id="submit">Login</button>

  </div>

  <div class="container" style="background-color:#f1f1f1">
    <!-- <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span> -->
  </div>

</body>

<script>
  $("#submit").click(function() {
    var usn = $('#usn').val();
    var pwd = $('#pwd').val();
    $.ajax({
      url: '/home.php',
      method: 'post',
      data: {
        username: usn,
        password: pwd,
      },
      success: function(res,body){
        console.log("OK",res);
      },
      error: function(res){
        console.log(res);
      },
    });
  });
</script>

</html>
