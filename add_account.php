<link rel="stylesheet" href="./Css/addform.css">

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


<br>
<div class="container1">
<div>
    <p style="margin-bottom: 10px; margin-left: 20px;">ADD FEEDBACK</p>
<div>
  <form action="" method="POST">
  <div class="row">
    <div class="col-25">
      <label for="fname">Username</label>
    </div>
    <div class="col-75">
      <input type="text" name="txtUsername" id="txtUsername" placeholder="Username"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">FEEDBACK</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">DATE</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtDes" name="txtDes" placeholder="">
    </div>
  </div>
  
  
  <br>
  <div class="row">
    <input type="submit" name="btnAdd" id="btnAdd" value="ADD">
    <a href="?page=feedback" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>