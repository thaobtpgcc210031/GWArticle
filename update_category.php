<link rel="stylesheet" href="./Css/addform.css">

<?php
    include_once("connection.php");
	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$result = mysqli_query($conn, "SELECT * FROM category WHERE Cat_ID = '$id'");
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$cat_id = $row['Cat_ID'];
		$cat_name = $row['Cat_Name'];
		$cat_des = $row['Cat_Des'];
	?>


<br>
<div class="container1">
    <p style="margin-bottom: 0px;">UPDATE CATEGORY</p>
<div>
<div class="container1">
  <form action="" method="POST">
  <div class="row">
    <div class="col-25">
      <label for="">ID category</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtID" name="txtID" readonly placeholder="Catepgy ID" value="<?php echo $cat_id ;?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" placeholder="Name category" value="<?php echo $cat_name ;?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Description</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtDes" name="txtDes" placeholder="Description of category" value="<?php echo $cat_des ;?>">
    </div>
  </div>
  
  
  <br>
  <div class="row">
    <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
    <a href="?page=category" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
<?php
	}else{
		echo '<meta http-equiv"refresh" content="0,URL=Category_Management.php"/>';
	}
	?>

<?php
		if(isset($_POST["btnUpdate"])){
			$id = $_POST["txtID"];
			$name = $_POST["txtName"];
			$des = $_POST["txtDes"];
			$err = "";
			if($name==""){
				$err.="<li>Enter category name</li>";
			}
			if($err!=""){
				echo "<ul>$err</ul>";
			}else{
				$sq="SELECT * FROM category WHERE Cat_ID != '$id' and Cat_Name = '$name'";
				$result = mysqli_query($conn,$sq);
				if(mysqli_num_rows($result)==0){
					mysqli_query($conn, "UPDATE category SET Cat_Name = '$name', Cat_Des = '$des'
					WHERE Cat_ID = '$id'");
					echo '<meta http-equiv="refresh" content="0,URL=index.php?page=category"/>';
				}else{
					echo "<li>Duplicate Category Name</li>";
				}
			}
		}
    ?>