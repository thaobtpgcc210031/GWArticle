<link rel="stylesheet" href="./Css/addform.css">

<?php
	include_once("connection.php");
	function bind_Category_List($conn, $selectedValue){
		$sqlstring = "SELECT Cat_ID, Cat_Name FROM category";
		$result = mysqli_query($conn, $sqlstring);
		echo "<select name='CategoryList'>
				<option value ='0'>Choose Category</option>";
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					if($row['Cat_ID']== $selectedValue){
						echo "<option value='" . $row['Cat_ID']."' selected>".$row['Cat_Name']."</option>";
					}else{
						echo "<option value='" .$row['Cat_ID']."'>".$row['Cat_Name']."</option>";
					}
				}
		echo "</select>";
	}

	if(isset($_GET["id"])){
		$id = $_GET["id"];
    $sqlstring="Select ShiName, ShiPrice, ShiDes, ShiDate, ShiImg,
    ShiQty, Cat_ID from shirt where ShiID='$id'";
    $result = mysqli_query($conn, $sqlstring);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
		$shirtname = $row["ShiName"];
		$shirtdes = $row["ShiDate"];
		$shirtprice = $row["ShiPrice"];
		$shirtqty = $row["ShiQty"];
		$shirtpic = $row['ShiImg'];
		$category = $row["Cat_ID"];

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
      <input type="text" id="txtID" name="txtID" readonly value='<?php echo $id; ?>' placeholder="ID of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Name</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtName" name="txtName" value='<?php echo $shirtname; ?>' placeholder="Name of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Category</label>
    </div>
    <div class="col-75">
      <?php bind_Category_List($conn, $category)  ?>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtPrice" name="txtPrice" value='<?php echo $shirtprice; ?>' placeholder="Price of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Description</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtDes" name="txtDes" value='<?php echo $shirtdes; ?>' placeholder="Description of shirt...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Quantity</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtQty" name="txtQty" value='<?php echo $shirtqty; ?>' placeholder="Quantity...">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Image</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtImage" name="txtImage" style="margin-top: 10px;" value='<?php echo $shirtpic;?>'/>
    </div>
  </div>
  
  
  <br>
  <div class="row">
    <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
    <a href="?page=product" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>

<?php
  if(isset($_POST["btnUpdate"])){
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
      if($shirtpic['name']!=""){
        if($shirtpic['type']=="image/jpg"  || $shirtpic['type']=="image/jpeg" || 
          $shirtpic['type']=="image/png" || $shirtpic['type']=="image/gif"){
            if($shirtpic['size'] <=614400){
              $sq="SELECT * FROM shirt WHERE ShiID !='$id' and ShiName = '$shirtname'";
              $result = mysqli_query($conn, $sq);
              if(mysqli_num_rows($result)==0){
                copy($shirtpic['tmp_name'], "product-imgs/".$shirtpic['name']);
                $filePic = $shirtpic['name'];

                $sqlstring = "UPDATE shirt SET 
                ShiName='$shirtname', ShiPrice=$shirtprice, ShiDes='$shirtdes',
                ShiDate='".date('Y-m-d H:i:s')."',ShiQty=$shirtqty,ShiImg='$filePic', Cat_ID='$category'
                WHERE ShiID='$id'";

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
      }else{
        $sq="Select * from shirt where ShiID = '$id' and ShiName='$shirtname'";
            $result= mysqli_query($conn, $sq);
            if(mysqli_num_rows($result)==0){
              $sqlstring="UPDATE shirt set ShiName='$shirtname', ShiPrice=$shirtprice,
                    ShiDes='$shirtdes', ShiImg='$shirtpic', ShiQty=$shirtqty, Cat_ID='$category',
                    ShiDate= '".date('Y-m-d H:i:s')."' WHERE ShiID='$id'";

                    mysqli_query($conn, $sqlstring);
                    echo'<meta http-equiv="refresh" content="0;URL=index.php?page=product"/>';
            }else{
              echo "<li>Duplicat product NAME</li>";
            }
          }
      }
  }


?>

<?php
}
else{
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=product"/>';
}
?>