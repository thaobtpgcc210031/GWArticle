<link rel="stylesheet" href="./Css/addform.css">
<?php
function bind_Department($conn){
  $sqlstring = "SELECT users.*, department.departmentID, department.departmentName  
                FROM users 
                LEFT JOIN department ON department.departmentID = users.depart
                WHERE users.UserID = '".$_SESSION["us"]."'";
  $result = mysqli_query($conn, $sqlstring);

  if(mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $current_department_id = $row['departmentID'];
      $current_department_name = $row['departmentName'];
  } else {
      // Nếu không có kết quả, mặc định là 0
      $current_department_id = 0;
      $current_department_name = "No Department";
  }

  // Sau khi lấy được thông tin của department hiện tại, tiến hành lấy danh sách các department
  $sqlstring_all_departments = "SELECT * FROM department";
  $result_all_departments = mysqli_query($conn, $sqlstring_all_departments);
  
  echo "<select name='Department'>";
  while($row_department = mysqli_fetch_array($result_all_departments, MYSQLI_ASSOC)){
      // Kiểm tra xem ID của department hiện tại có trùng khớp với ID của department trong danh sách hay không
      $selected = ($current_department_id == $row_department['departmentID']) ? 'selected' : '';
      echo "<option value='".$row_department['departmentID']."' $selected>".$row_department['departmentName']."</option>";
  }
  echo "</select>";
}


    function bind_Role($conn){
      $sqlstring = "SELECT * FROM Roles";
      $result = mysqli_query($conn, $sqlstring);
      
      // Lấy ID của department hiện tại thông qua session
      $current_role_id = isset($_SESSION['us']) ? $_SESSION['us'] : 0;
  
      echo "<select name='Role'>";
      while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
          // Kiểm tra xem ID của department hiện tại có trùng với ID trong danh sách không
          $selected = ($current_role_id == $row['RoleID']) ? 'selected' : '';
          echo "<option value='".$row['RoleID']."' $selected>".$row['RoleName']."</option>";
      }
      echo "</select>";
  }
      


	if(isset($_GET["id"])){
		$id = $_GET["id"];
    $sqlstring="Select * From users where UserID='$id'";
    $result = mysqli_query($conn, $sqlstring);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
		$usrname = $row["Username"];
		$pass = $row["Password"];
		$mail = $row["Email"];
		$fName = $row['fullName'];
		$addr = $row["Address"];
    $phone = $row["Phone"];
    echo $_SESSION["us"];

?>


<br>

<div class="container1">
<div>
    <p style="margin-bottom: 10px; margin-left: 20px;">UDATE ARTICLE</p>
<div>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="">User Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtID" name="txtID" readonly value='<?php echo $usrname; ?>' placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Password</label>
    </div>
    <div class="col-75">
      <input type="password" id="txtPass" name="txtPass" readonly value='<?php echo $pass; ?>' placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">EMail</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtMail" name="txtMail" value='<?php echo $mail; ?>' placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Role</label>
    </div>
    <div class="col-75">
    <div class="dropdown" id="txtRole" name="txtRole"><?php bind_Role($conn) ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Department</label>
    </div>
    <div class="col-75">
    <div class="dropdown" id="txtDepart" name="txtDepart"><?php bind_Department($conn) ?></div>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Full Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" value='<?php echo $fName; ?>' placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Address</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtAddr" name="txtAddr" value='<?php echo $addr; ?>' placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Phone</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtPhone" name="txtPhone" value='<?php echo $phone; ?>' placeholder="">
    </div>
  </div>
  <br>
  <div class="row">
    <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
    <a href="?page=manage_account" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>

<?php
  if(isset($_POST["btnUpdate"])){
		$mail = $_POST["txtMail"];
		$fName = $_POST["txtName"];
		$addr = $_POST['txtAddr'];
		$phone = $_POST['txtPhone'];
    $role = $_POST['txtPhone'];
    $deaprt = $_POST['txtPhone'];
    $department = $_POST['Department'];
    $role = $_POST['Role'];
    $pass = $_POST['txtPass'];

    $err="";
    if(trim($id)==""){
      $err .= "<li>Enter ID </li>";
    // }
    // if(trim($contri)==""){
    //   $err .= "<li>Enter name </li>";
    // }
    // if(trim($aca)=="0"){
    //   $err .= "<li>Choose category </li>";
    // }
    // if(trim($publ)){
    //   $err .= "<li>Must be number </li>";
    // }
    // if(trim($shirtqty)){
    //   $err .= "<li>Must be number </li>";
    // }
    // if($err !=""){
    //   echo "<ul>$err</ul>";
    // }else{
    //   if($shirtpic['name']!=""){
    //     if($shirtpic['type']=="image/jpg"  || $shirtpic['type']=="image/jpeg" || 
    //       $shirtpic['type']=="image/png" || $shirtpic['type']=="image/gif"){
    //         if($shirtpic['size'] <=614400){
              // $sq="SELECT * FROM shirt WHERE ShiID !='$id' and ShiName = '$shirtname'";
              // $result = mysqli_query($conn, $sq);
              // if(mysqli_num_rows($result)==0){
              //   copy($shirtpic['tmp_name'], "product-imgs/".$shirtpic['name']);
              //   $filePic = $shirtpic['name'];

              //   $sqlstring = "UPDATE shirt SET 
              //   ShiName='$shirtname', ShiPrice=$shirtprice, ShiDes='$shirtdes',
              //   ShiDate='".date('Y-m-d H:i:s')."',ShiQty=$shirtqty,ShiImg='$filePic', Cat_ID='$category'
              //   WHERE ShiID='$id'";

              // mysqli_query($conn, $sqlstring);
              // echo'<meta http-equiv="refresh" content="0;URL=index.php?page=article"/>';
      //       }else{
      //         echo "<li>Duplicat product ID or NAME</li>";
      //       }
      //     }else{
      //       echo "Size of image too big";
      //     }
      // }else{
      //   echo "Image format is not correct";
      // }


      }else{
        $sq="Select * from magazine where MagazineID = '$id' and ContentM = '$conte'";
            $result= mysqli_query($conn, $sq);
            if(mysqli_num_rows($result)==0){
              $sqlstring="UPDATE users set Email='$mail', fullName='$fName', Password='$pass',
                    Address='$addr', Phone='$phone',Role='$role',Depart='$department'
                     WHERE UserID='$id'";
                    mysqli_query($conn, $sqlstring);
                    echo'<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
            }else{
              echo "<li>....</li>";
            }
          }
      }
  // }
?>

<?php
  }
else{
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
}
?>