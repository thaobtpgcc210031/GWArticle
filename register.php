<?php
include_once("connection.php");

function bind_Role($conn){
  $sqlstring = "SELECT * FROM roles";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='Roles'>
      <option value ='0'>Choose Roles</option>";
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        echo "<option value='".$row['RoleID']."'>".$row['RoleName']."</option>";
      }
  echo "</select>";
}

function bind_Department($conn){
  $sqlstring = "SELECT * FROM department";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='Department'>
      <option value ='0'>Choose Department</option>";
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        echo "<option value='".$row['departmentID']."'>".$row['departmentName']."</option>";
      }
  echo "</select>";
}

if(isset($_POST['btnRegister'])){	
	$us = $_POST['txtUsername'];
	$pass1 = $_POST['txtPass1'];
	$pass2 = $_POST['txtPass2'];
	$fullname = $_POST['txtName'];
	$email = $_POST['txtEmail'];
	$tele = $_POST['txtPhone'];
	$address = $_POST['txtAddress'];	
  $department = $_POST['Department'];
  
	$err = "";

	if($us==""||$pass1=="" ||$pass2==""||$fullname==""
	||$email==""||$address==""||$tele==""||$department==""){
		$err .="<li>Enter information fully, please</li>";
	}
	
	if(strlen($pass1)<=5){ // Sửa lỗi về độ dài mật khẩu
		$err .="<li>Password must be greater than 5 chars</li>";
	}
	
	if($pass1 != $pass2){
		$err .="<li>Password and confirm password do not match</li>"; // Sửa thông báo lỗi
	}
    

	if($err != ""){
		echo "<ul>".$err."</ul>"; // Sửa hiển thị thông báo lỗi
	}
	else{
        
        $pass = md5($pass1);
        $sq = "SELECT * FROM users WHERE Username='$us' OR Email='$email'"; // Sửa lỗi so sánh email
        $res = mysqli_query($conn,$sq);
        if(mysqli_num_rows($res)==0){
            mysqli_query($conn, "
                                INSERT INTO users(`Username`, `Password`, `Email`, `Depart`, `FullName`, `Address`, `Phone`) 
                                VALUES ('$us','$pass' ,'$email','$department','$fullname','$address','$tele')") or die(mysqli_error($conn));
                                echo "You have registered successfully";
        }else{
		      echo "Username or email already exists";
        }
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Page</title>
  <link rel="stylesheet" href="./Css/style.css">
</head>
<style>
.dropdown{
padding-right: 15px;
padding-left: 0px;
margin: 0 0 15px;
width: 100%;
font-size: 14px;

}
select{
  width: 100%;
  padding: 15px;
  padding-left: 10px;
  background-color:#f2f2f2 ;
  border: 0;
  font-size: 14px;
  color:#828282 ;
}
</style>

<body>
  <div class="login-page">
    <div class="form">
      <div class="login">
        <div class="login-header">
          <h3>CREATE YOUR ACCOUNT</h3>
        </div>
      </div>
      <form class="login-form" name="register-form" method="POST">
        <input type="text" name="txtUsername" id="txtUsername" placeholder="Username"/>
        <input type="password" name="txtPass1" id="txtPass1" placeholder="Password"/>
        <input type="password" name="txtPass2" id="txtPass2" placeholder="Confirm password"/>
        <input type="text" name="txtName" id="txtName" placeholder="Full name"/>
        <input type="text" name="txtEmail" id="txtEmail" placeholder="Email"/>
        <input type="text" name="txtPhone" id="txtPhone" placeholder="Phone number"/>
        <input type="text" name="txtAddress" id="txtAddress" placeholder="Address"/>
        <div class="dropdown"><?php bind_Department($conn) ?></div>
        <button type="submit" name="btnRegister" id="btnRegister" value="Register">REGISTER</button>
        <p class="message">Already have an account! <a href="login.php">LOGIN</a></p>
      </form>
    </div>
  </div>
</body>
</html>
