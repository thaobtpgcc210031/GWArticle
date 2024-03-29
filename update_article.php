<link rel="stylesheet" href="./Css/addform.css">

<?php
include_once("connection.php");
function bind_Contribution_List($conn, $selectedValue)
{
  $sqlstring = "SELECT ContributionID,Title FROM contributions";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='contributionsList'>
				<option value ='0'>Choose contributions</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    if ($row['ContributionID'] == $selectedValue) {
      echo "<option value='" . $row['ContributionID'] . "' selected>" . $row['Title'] . "</option>";
    } else {
      echo "<option value='" . $row['ContributionID'] . "'>" . $row['Title'] . "</option>";
    }
  }
  echo "</select>";
}

function bind_Closure_List($conn, $selectedValue)
{
  $sqlstring = "SELECT idC,Closuredate, FinalClosuredate FROM closure";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='closureList'>
				<option value ='0'>Choose Closure and FinalClosuredate</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    if ($row['idC'] == $selectedValue) {
      echo "<option value='" . $row['idC'] . "' selected>" . $row['Closuredate'] . " And ". $row['FinalClosuredate'] ."</option>";
    } else {
      echo "<option value='" . $row['idC'] . "'>" . $row['Closuredate'] . " And ". $row['FinalClosuredate'] ."</option>";
    }
  }
  echo "</select>";
}



include_once("connection.php");
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sqlstring = "Select ContributionID, AcaYear, PublicationDate, ContentM, idC From magazine where MagazineID='$id'";
  $result = mysqli_query($conn, $sqlstring);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  // $maga = $row["MagazineID"];
  $contri = $row["ContributionID"];
  $aca = $row["AcaYear"];
  // $publ = $row["PublicationDate"];
  $conte = $row['ContentM'];
  $closure = $row["idC"];


?>
  <br>
  <div class="container1">
    <div>
      <p style="margin-bottom: 10px; margin-left: 20px;">UDATE ARTICLE</p>
      <div>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-25">
              <label for="">ID</label>
            </div>
            <div class="col-75">
              <input type="text" id="txtID" name="txtID" readonly value='<?php echo $id; ?>' placeholder="...">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-4 control-label">Contribution : </label>
            <div class="col-sm-8">
              <?php bind_Contribution_List($conn, $contri); ?>
            </div>
          </div>
          <div class="row">
            <div class="col-25">
              <label for="">Academic Year</label>
            </div>
            <div class="col-75">
              <input type="text" id="txtAca" name="txtAca" value='<?php echo $aca; ?>' placeholder="...">
            </div>
          </div>
         
          <div class="row">
            <div class="col-25">
              <label for="">Content</label>
            </div>
            <div class="col-75">
              <input type="text" id="txtCont" name="txtCont" value='<?php echo $conte; ?>' placeholder="">
            </div>
          </div>




          <div class="form-group">
            <label for="" class="col-sm-4 control-label">Closure: </label>
            <div class="col-sm-8">
              <?php bind_Closure_List($conn, $closure); ?>
            </div>
          </div>
   

      <br>
      <div class="row">
        <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
        <a href="?page=article" class="btn_back"><span>Back &#10148; </span></a>
      </div>

      </form>
    </div>
  </div>
  </div>

  <?php
  include_once("connection.php");
  if (isset($_POST["btnUpdate"])) {
    $contri = $_POST["contributionsList"];
    $aca = $_POST["txtAca"];
    $conte = $_POST['txtCont'];
    $closure = $_POST["closureList"];



    $err = "";
    if (trim($id) == "") {
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


    } else {
      $sq = "Select * from magazine where MagazineID = '$id' and ContentM = '$conte'";
      $result = mysqli_query($conn, $sq);
      if (mysqli_num_rows($result) == 1) {
        $sqlstring = "UPDATE magazine set ContributionID='$contri', AcaYear='$aca',
                    PublicationDate=current_timestamp(), ContentM='$conte', idC='$closure'
                     WHERE MagazineID='$id'";
        mysqli_query($conn, $sqlstring);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?page=article"/>';
      } else {
        echo "<li>Duplicat product NAME</li>";
      }
    }
  }
  // }
  ?>

<?php
} else {
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=article"/>';
}
?>