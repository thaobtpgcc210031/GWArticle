<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./Css/style.css">
<link rel="icon" href="./Icon/icon.ico" type="image/x-icon">
<title> GW | Login</title>
</head>
<?php
if(isset($_POST['btnLogin'])){
  $us = $_POST['txtUsername'];
  $pa = $_POST['txtPass'];
  $err = "";

  if($us==""){
    $err .= "Enter Username, please<br/>";
  }
  if($pa==""){
    $err .= "Enter Password, please<br/>";
  }

  if($err != ""){
		echo $err;
	}
  else{
    session_start();
		include_once("connection.php");
		$pass = md5($pa);
		$us= mysqli_real_escape_string($conn, $us);
		$res = mysqli_query($conn, "SELECT * FROM users WHERE Username='$us' and Password='$pass'") or die(mysqli_error($conn));
		$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    
		if(mysqli_num_rows($res)==1){
      $Role = $row['Role'];
      $depart = $row['Depart'];
      $id = $row['UserID'];
      $name = $row['fullName'];
      $_SESSION["role"] = $Role;
      $_SESSION["fullName"] = $name;
      $_SESSION["depart"] = $depart;
			$_SESSION["us"] = $us;
      $_SESSION["id"] = $id;
      echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
		}else{
			echo "You loged fail";
		}
	}
}
?>

<body>
  <body>
    <div class="login-page">
      <div class="form">
        <div class="login">
          <div class="login-header">
            <h3>WELCOME</h3>
          </div>
        </div>
        <form class="login-form" method="POST">
          <input type="text" name="txtUsername" id="txtUsername" placeholder="username"/>
          <input type="password" name="txtPass" id="txtPass" placeholder="password"/>
          <button type="submit" name="btnLogin" id="btnLogin">login</button>
          <p class="message">Not registered? <a href="register.php">Create an account</a></p>
        </form>
      </div>
    </div>
</body>
</body>
</html>