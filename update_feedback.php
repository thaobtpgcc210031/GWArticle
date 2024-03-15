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
    <p style="margin-bottom: 0px;">UPDATE ARTICLE</p>
<div>
<div class="container1">
  <form action="" method="POST">
  <div class="row">
    <div class="col-25">
      <label for="">ID ARTICLE</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtID" name="txtID" readonly placeholder="Catepgy ID" value="<?php echo $cat_id ;?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">TITLE</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" placeholder="Name category" value="<?php echo $cat_name ;?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">STATUS</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtDes" name="txtDes" placeholder="Description of category" value="<?php echo $cat_des ;?>">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">STATUS</label>
    </div>
    <div class="col-75">
    <form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
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
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
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