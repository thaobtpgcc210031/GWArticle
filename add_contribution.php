<link rel="stylesheet" href="./Css/addform.css">

<?php
	include_once("connection.php");
	function bind_Category($conn){
		$sqlstring = "SELECT StudentID FROM contribution";
		$result = mysqli_query($conn, $sqlstring);
		echo "<select name='Contribution'>
				<option value ='0'>Contribution</option>";
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo "<option value='".$row['StudentID']."</option>";
				}
		echo "</select>";
	}

	if(isset($_POST["btnAdd"])){
		$id = $_POST["txtStudentID"];
		$til = $_POST["txtTitle"];
		$contentP = $_POST["txtContentp"];
		$sub = $_POST["lblSubmissionDate"];
		$status = $_POST["txtStatus"];
		$file = $_FILES['txtFileP'];
		$ImgCv = $_FILES["txtImageCv"];
        $ImgS = $_FILES["txtImageSample"];
		$err="";
		if(trim($id)==""){
			$err .= "<li>Enter ID </li>";
		}
		if(trim($til)==""){
			$err .= "<li>Enter name </li>";
		}
		if(trim($contentP)=="0"){
			$err .= "<li>Choose contentP </li>";
		}
		if(date($sub)){
			$err .= "<li>Must be choose date </li>";
		}
		if(!is_numeric($status)){
			$err .= "<li>Enter status </li>";
		}
        if(!file($file)){
			$err .= "<li>Enter File </li>";
		}
        if(!file($ImgCv)){
			$err .= "<li>Enter image CV </li>";
		}
        if(!file($ImgS)){
			$err .= "<li>Enter image sanple </li>";
		}


		if($err !=""){
			echo "<ul>$err</ul>";
		}else{
			if($shirtpic['type']=="image/jpg"  || $shirtpic['type']=="image/jpeg" || 
				$shirtpic['type']=="image/png" || $shirtpic['type']=="image/gif"){
					if($shirtpic['size'] <=614400){
						$sq="SELECT * FROM contribution WHERE StudentID ='$id' or Title= '$til'";
						$result = mysqli_query($conn, $sq);
						if(mysqli_num_rows($result)==0){
							copy($ImgCv['tmp_name'], "product-imgs/".$ImgCv['name']);
							$filePic = $ImgCv['name'];
							$sqlstring = "INSERT INTO contribution(
								StudentID, Title, ContentP, SubmissionDate, Status,
								FileP,ImgCv, ImgSample)
								VALUES ('$id', '$til', $contentP, '$sub', '".date('Y-m-d H:i:s')."',
								$status, '$fileP', '$ImgCv', '$ImgS)";
							mysqli_query($conn, $sqlstring);
							echo'<meta http-equiv="refresh" content="0;URL=index.php?page=contribution"/>';
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
    <p style="margin-bottom: 10px; margin-left: 20px;">ADD CONTRIBUTION</p>
<div>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="">STUDENT ID</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtStudentID" name="txtStudentID" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">TITLE</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtTitle" name="txtTitle" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">CONTENT</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtContentp" name="txtContentp" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">SUBMISSTIONDATE</label>
    </div>
    <div class="col-75">
      <input type="date" id="lblSubmissionDate" name="lblSubmissionDate" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">STATUS</label>
    </div>
    <div class="col-75">
      <input type="text" id="txtStatus" name="txtStatus" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">FILE</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtFileP" name="txtFileP" placeholder="">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Image CV</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtImageCv" name="txtImageCv" style="margin-top: 10px;" value=""/>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="">Image Sample</label>
    </div>
    <div class="col-75">
      <input type="file" id="txtImageSample" name="txtImageSample" style="margin-top: 10px;" value=""/>
    </div>
  </div>
  
  <br>
  <div class="row">
    <input type="submit" name="btnAdd" id="btnAdd" value="ADD">
    <a href="?page=contribution" class="btn_back"><span>Back &#10148; </span></a>
  </div>
 
  </form>
</div>
</div>
</div>