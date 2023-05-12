<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  

<link rel="stylesheet" href="./Css/style.css">
<meta charset="utf-8" />
<?php
if(isset($_POST['btnRegister'])){	
	$us = $_POST['txtUsername'];
	$pass1 = $_POST['txtPass1'];
	$pass2 = $_POST['txtPass2'];
	$fullname = $_POST['txtName'];
	$email = $_POST['txtEmail'];
	$phone = $_POST['txtPhone'];
	$address = $_POST['txtAddress'];	
	$err = "";

	if($us==""||$pass1=="" ||$pass2==""||$fullname==""
	||$email==""||$address==""||$phone=""){
		$err .="<li>Enter information fully, please</li>";
	}
	
	if(strlen($pass1)<=3){
		$err .="<li>Password must be greater than 5 chars</li>";
	}
	
	if($pass1!=$pass2){
		$err .="<li>Password and confirm password are the same</li>";
	}
    

	if($err!= ""){
		echo $err;
	}
	else{
        include_once("connection.php");
        $pass = md5($pass1);
        $sq = "SELECT * FROM user WHERE Username='$us' OR email='$email'";
        $res = mysqli_query($conn,$sq);
        if(mysqli_num_rows($res)==0){
            mysqli_query($conn, "INSERT INTO user (Username, Password, email, fullName, address ,telephone)
                                VALUES ('$us','$pass' ,'$email','$fullname','$address','$phone')") or die(mysqli_error($conn));
                                echo "You have registered successfully";
        }else{
		      echo "Username or email already exists";
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
            <h3>CREATE YOUR ACCOUNT</h3>
          </div>
        </div>
        <form class="login-form" name="register-form" method="POST">
          <input type="text" name="txtUsername" id="txtUsername" placeholder="username"/>
          <input type="password" name="txtPass1" id="txtPass1" placeholder="password"/>
          <input type="password" name="txtPass2" id="txtPass2" placeholder="confirm password"/>
          <input type="text" name="txtName" id="txtName" placeholder="full name"/>
          <input type="text" name="txtEmail" id="txtEmail" placeholder="email"/>
          <input type="text" name="txtPhone" id="txtPhone" placeholder="phone number"/>
          <input type="text" name="txtAddress" id="txtAddress" placeholder="Address"/>
          <button type="submit" name="btnRegister" id="btnRegister" value="Register">REGISTER</button>
          <p class="message">Already have an account! <a href="login.php">LOGIN</a></p>
        </form>
      </div>
    </div>
</body>
</body>
</html>