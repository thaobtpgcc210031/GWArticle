<link rel="stylesheet" href="./Css/addform.css">

<?php
	include_once("connection.php");
	if(isset($_POST["btnAdd"]))
	{
		$id = $_POST["txtID"];
		$name = $_POST["txtName"];
		$des = $_POST["txtDes"];
		$err="";
		if($id==""){
			$err.="<li>Enter ID</li>";
		}
		if($name==""){
			$err.="<li>Enter Name<li>";
		}
		if($err!=""){
			echo "<ul>$err</ul>";
		}else{
			$id = htmlspecialchars(mysqli_real_escape_string($conn,$id));
			$name = htmlspecialchars(mysqli_real_escape_string($conn,$name));
			$des = htmlspecialchars(mysqli_real_escape_string($conn,$des));
			$sq="SELECT * FROM category where Cat_ID='$id' or Cat_Name='$name'";
			$result = mysqli_query($conn,$sq);
			if(mysqli_num_rows($result)==0){
				mysqli_query($conn, "INSERT INTO category (Cat_ID, Cat_Name, Cat_Des)
				VALUES ('$id','$name','$des')");
				echo '<meta http-equiv="refresh" content="0;URL=index.php?page=category"/>';
			}else{
				echo "<li>Duplicate catgory ID or Name</li>";
			}
		}
	}
	?>


<br>
<div class="container1">
<div>
    <p style="margin-bottom: 10px; margin-left: 20px;">ADD CATEGORY</p>
<div>
  <form action="" method="POST">
  <div class="row">
    <div class="col-25">
      <label for="fname">ID category</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtID" name="txtID" placeholder="ID of category...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" placeholder="Name of category...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Description</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtDes" name="txtDes" placeholder="Description of category...">
    </div>
  </div>
  
  
  <br>
  <div class="row">
    <input type="submit" name="btnAdd" id="btnAdd" value="ADD">
    <a href="?page=category" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>