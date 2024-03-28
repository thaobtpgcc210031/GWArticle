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

    $sqlstudentid = "SELECT UserID FROM users WHERE Username = '".$_SESSION["us"]."'";

	if(isset($_POST["btnAdd"])){
		$id = $sqlstudentid;
		$title = $_POST["txtTitle"];
		$content = $_POST["txtContentP"];
		$file = $_FILES["txtFile"];
		$cv = $_FILES["txtCv"];
		$sample = $_FILES['txtSample'];
        $currentDateTime = date('Y-m-d H:i:s');
		$err="";
		if(trim($title)==""){
			$err .= "<li>Enter Title </li>";
		}
		if($err !=""){
			echo "<ul>$err</ul>";
		}else{

							copy($cv['tmp_name'], "imgs/cv/".$cv['name']);
							$filePic = $cv['name'];
							$sqlstring = "INSERT INTO contributions(
								Title, ContentP, SubmissionDate, FileP, ImgCV,
								ImgSample)
								VALUES ('$title', '$content', '$currentDateTime', '$file', '$filePic','$sample')";
							mysqli_query($conn, $sqlstring);
							echo'<meta http-equiv="refresh" content="0;URL=index.php?page=product"/>';
	
		}
	}

	
?>


<br>
<div class="container1">
<div>
    <p style="margin-bottom: 10px; margin-left: 20px;">ADD CONTRIBUTION</p>
<div>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="">Title</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtTitle" name="txtTitle" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Content</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtContentP" name="txtContentP" placeholder="">
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="">File</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtFile" name="txtFile" style="margin-top: 10px;" value=""/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Image Cover</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtCv" name="txtCv" style="margin-top: 10px;" value=""/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Image Sample</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtSample" name="txtSample" style="margin-top: 10px;" value=""/>
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