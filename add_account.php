<style>
/* Reset some default styles */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container1 {
    margin: 20px auto;
    width: 50%;
}

p {
    font-size: 24px;
    font-weight: bold;
    margin-left: 20px;
}

form {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
}

.row {
    margin-bottom: 20px;
}

.col-25 {
    float: left;
    width: 25%;
}

.col-75 {
    float: left;
    width: 75%;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

input[type=text],
input[type=password] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
}

select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.btn_back {
    background-color: #f44336;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.btn_back:hover {
    background-color: #d32f2f;
}

</style>
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

if(isset($_POST['btnAddAccount'])){	
	$us = $_POST['txtUsername'];
	$pass1 = $_POST['txtPass1'];
	$pass2 = $_POST['txtPass2'];
	$fullname = $_POST['txtName'];
	$email = $_POST['txtEmail'];
	$tele = $_POST['txtPhone'];
	$address = $_POST['txtAddress'];	
  $department = $_POST['Department'];
  $role = $_POST['Roles'];
  
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
                                INSERT INTO users(`Username`, `Password`, `Email`, `Depart`,`Role`, `FullName`, `Address`, `Phone`) 
                                VALUES ('$us','$pass' ,'$email','$department','$role','$fullname','$address','$tele')") or die(mysqli_error($conn));
                                echo "You have created account successfully";
        }else{
		      echo "Username or email already exists";
        }
	}
}
?>


<br>
<div class="container1">
<div>
    <p style="margin-bottom: 10px; margin-left: 20px; font-weight:bold;">Add New Account</p>
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
      <label for="lname">Password</label>
    </div>
    <div class="col-75">
      <input type="password" name="txtPass1" id="txtPass1" placeholder="Password"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Confirm Password</label>
    </div>
    <div class="col-75">
      <input type="password" name="txtPass2" id="txtPass2" placeholder="Confirm password"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Full Name</label>
    </div>
    <div class="col-75">
      <input type="text" name="txtName" id="txtName" placeholder="Full name"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Email</label>
    </div>
    <div class="col-75">
      <input type="text" name="txtEmail" id="txtEmail" placeholder="Email"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Phone Number</label>
    </div>
    <div class="col-75">
      <input type="text" name="txtPhone" id="txtPhone" placeholder="Phone number"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Address</label>
    </div>
    <div class="col-75">
      <input type="text" name="txtAddress" id="txtAddress" placeholder="Address"/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Department</label>
    </div>
    <div class="col-75">
      <div class="dropdown"><?php bind_Department($conn) ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Role</label>
    </div>
    <div class="col-75">
      <div class="dropdown"><?php bind_Role($conn) ?></div>
    </div>
  </div>
  
  
  <br>
  <div class="row">
    <input type="submit" name="btnAddAccount" id="btnAddAccount" value="ADD">
    <a href="?page=manage_account" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>