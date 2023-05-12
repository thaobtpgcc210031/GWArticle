<link rel="stylesheet" href="./Css/addform.css">

<?php
	include_once("connection.php");
	function bind_Category($conn){
		$sqlstring = "SELECT Cat_ID, Cat_Name FROM category";
		$result = mysqli_query($conn, $sqlstring);
		echo "<select name='CategoryList'>
				<option value ='0'>Choose Category</option>";
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo "<option value='".$row['Cat_ID']."'>".$row['Cat_Name']."</option>";
				}
		echo "</select>";
	}

	if(isset($_POST["btnAdd"])){
		$id = $_POST["txtID"];
		$shirtname = $_POST["txtName"];
		$shirtdes = $_POST["txtDes"];
		$shirtprice = $_POST["txtPrice"];
		$shirtqty = $_POST["txtQty"];
		$shirtpic = $_FILES['txtImage'];
		$category = $_POST["CategoryList"];
		$err="";
		if(trim($id)==""){
			$err .= "<li>Enter ID </li>";
		}
		if(trim($shirtname)==""){
			$err .= "<li>Enter name </li>";
		}
		if(trim($category)=="0"){
			$err .= "<li>Choose category </li>";
		}
		if(!is_numeric($shirtprice)){
			$err .= "<li>Must be number </li>";
		}
		if(!is_numeric($shirtqty)){
			$err .= "<li>Must be number </li>";
		}
		if($err !=""){
			echo "<ul>$err</ul>";
		}else{
			if($shirtpic['type']=="image/jpg"  || $shirtpic['type']=="image/jpeg" || 
				$shirtpic['type']=="image/png" || $shirtpic['type']=="image/gif"){
					if($shirtpic['size'] <=614400){
						$sq="SELECT * FROM shirt WHERE ShiID ='$id' or ShiName= '$shirtname'";
						$result = mysqli_query($conn, $sq);
						if(mysqli_num_rows($result)==0){
							copy($shirtpic['tmp_name'], "product-imgs/".$shirtpic['name']);
							$filePic = $shirtpic['name'];
							$sqlstring = "INSERT INTO Shirt(
								ShiID, ShiName, ShiPrice, ShiDes, ShiDate,
								ShiQty,ShiImg, Cat_ID)
								VALUES ('$id', '$shirtname', $shirtprice, '$shirtdes', '".date('Y-m-d H:i:s')."',
								$shirtqty, '$filePic', '$category')";
							mysqli_query($conn, $sqlstring);
							echo'<meta http-equiv="refresh" content="0;URL=index.php?page=product"/>';
						}else{
							echo "<li>Duplicat product ID or NAME</li>";
						}
					}else{
						echo "Size of image too big";
					}
			}else{
				echo "Image format is not correct";
			}
		}
	}

	
?>


<br>
<div class="container1">
<div>
    <p style="margin-bottom: 10px; margin-left: 20px;">ADD PRODUCT</p>
<div>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="">Shirt ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtID" name="txtID" placeholder="ID of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" placeholder="Name of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Category</label>
    </div>
    <div class="col-75">
      <?php bind_Category($conn)  ?>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtPrice" name="txtPrice" placeholder="Price of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Description</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtDes" name="txtDes" placeholder="Description of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Quantity</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtQty" name="txtQty" placeholder="Quantity...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Image</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtImage" name="txtImage" style="margin-top: 10px;" value=""/>
    </div>
  </div>
  
  
  <br>
  <div class="row">
    <input type="submit" name="btnAdd" id="btnAdd" value="ADD">
    <a href="?page=product" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>