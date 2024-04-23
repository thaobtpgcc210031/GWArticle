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
function bind_Department($conn, $selectedValue)
{
  $sqlstring = "SELECT * FROM department";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='Department'>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    // Kiểm tra xem ID của department hiện tại có trùng với ID trong danh sách không
    if ($row['departmentID'] == $selectedValue) {
      echo "<option value='" . $row['departmentID'] . "' selected>" . $row['departmentName'] . "</option>";
    } else {
      echo "<option value='" . $row['departmentID'] . "'>" . $row['departmentName'] . "</option>";
    }
  }
  echo "</select>";
}



function bind_Role($conn, $selectedValue)
{
  $sqlstring = "SELECT * FROM Roles";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='Role'>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    // Kiểm tra xem ID của department hiện tại có trùng với ID trong danh sách không
    if ($row['RoleID'] == $selectedValue) {
      echo "<option value='" . $row['RoleID'] . "' selected>" . $row['RoleName'] . "</option>";
    } else {
      echo "<option value='" . $row['RoleID'] . "'>" . $row['RoleName'] . "</option>";
    }
  }
  echo "</select>";
}



if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sqlstring = "Select * From users where UserID='$id'";
  $result = mysqli_query($conn, $sqlstring);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $role = $row['Role'];
  $usrname = $row["Username"];
  $pass = $row["Password"];
  $mail = $row["Email"];
  $fName = $row['fullName'];
  $addr = $row["Address"];
  $phone = $row["Phone"];
  $depart = $row['Depart'];
  // echo $_SESSION["us"];

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
              <div class="dropdown" id="txtRole" name="txtRole"><?php bind_Role($conn, $role) ?></div>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="">Department</label>
            </div>
            <div class="col-75">
              <div class="dropdown" id="txtDepart" name="txtDepart"><?php bind_Department($conn, $depart) ?></div>
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
  if (isset($_POST["btnUpdate"])) {
    $mail = $_POST["txtMail"];
    $fName = $_POST["txtName"];
    $addr = $_POST['txtAddr'];
    $phone = $_POST['txtPhone'];
    $role = $_POST['txtPhone'];
    $deaprt = $_POST['txtPhone'];
    $department = $_POST['Department'];
    $role = $_POST['Role'];
    $pass = $_POST['txtPass'];

    $err = "";
    if (trim($id) == "") {
    $err .= "<li>Enter ID </li>";
    }else{
            $sq = "Select * from users where UserID = '$id'";
      $result = mysqli_query($conn, $sq);
      if (mysqli_num_rows($result) == 1) {
        $sqlstring = "UPDATE users set Email='$mail', fullName='$fName', Password='$pass',
                    Address='$addr', Phone='$phone',Role='$role',Depart='$department'
                     WHERE UserID='$id'";
        mysqli_query($conn, $sqlstring);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
      } else {
        echo "<li>....</li>";
      }
    }

    
  }
  // }
  ?>

<?php
} else {
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
}
?>