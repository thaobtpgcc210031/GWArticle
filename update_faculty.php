<link rel="stylesheet" href="./Css/addform.css">

<?php
include_once("connection.php");
// function bind_Category_List($conn, $selectedValue)
// {
//     $sqlstring = "SELECT * FROM magazine";
//     $result = mysqli_query($conn, $sqlstring);
//     echo "<select name='CategoryList'>
// 				<option value ='0'>Choose Category</option>";
//     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//         if ($row['MagazineID'] == $selectedValue) {
//             echo "<option value='" . $row['MagazineID'] . "' selected>" . $row['Cat_Name'] . "</option>";
//         } else {
//             echo "<option value='" . $row['MagazineID'] . "'>" . $row['Cat_Name'] . "</option>";
//         }
//     }
//     echo "</select>";
// }

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sqlstring = "Select * From department where departmentID='$id'";
    $result = mysqli_query($conn, $sqlstring);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $maga = $row["departmentID"];
    $contri = $row["departmentName"];
    $aca = $row["DeDes"];
    
    
    // $publ = $row["PublicationDate"];
    // $conte = $row['ContentM'];
    // $closure = $row["ClosureDate"];
    // $finalclo = $row["FinalClosureDate"];

?>


    <br>
    <div class="container1">
        <div>
            <p style="margin-bottom: 10px; margin-left: 20px;">UDATE FACULTY</p>
            <div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-25">
                            <label for="">Department ID</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtID" name="txtID" readonly value='<?php echo $maga; ?>' placeholder="ID of ...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="">Department Name</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtCon" name="txtCon" value='<?php echo $contri; ?>' placeholder="Name of ...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="">Description Year</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtAca" name="txtAca" value='<?php echo $aca; ?>' placeholder="">
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-25">
                            <label for="">Public Date</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtPub" name="txtPub" value='<?php echo $publ; ?>' placeholder="Price of shirt...">
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
                    <div class="row">
                        <div class="col-25">
                            <label for="">Closure Date</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtClo" name="txtClo" value='<?php echo $closure; ?>' placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="">Final Closure Date</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtFClo" name="txtFClo" value='<?php echo $finalclo; ?>' placeholder="">
                        </div>
                    </div>
 -->
                    <br>
                    <div class="row">
                        <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
                        <a href="?page=faculty" class="btn_back"><span>Back &#10148; </span></a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST["btnUpdate"])) {
        $contri = $_POST["txtCon"];
        $aca = $_POST["txtAca"];
        
        // $publ = $_POST["txtPub"];
        // $conte = $_POST['txtCont'];
        // $closure = $_POST["txtClo"];
        // $finalclo = $_POST["txtFClo"];


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
            $sq = "Select * from department where departmentID = '$id' and departmentName = '$contri'";
            $result = mysqli_query($conn, $sq);
            if (mysqli_num_rows($result) == 0) {
                $sqlstring = "UPDATE department set departmentName='$contri', DeDes=$aca
                     WHERE departmentID='$id'";
                mysqli_query($conn, $sqlstring);
                echo '<meta http-equiv="refresh" content="0;URL=index.php?page=faculty"/>';
            } else {
                echo "<li>Duplicat Faculty NAME</li>";
            }
        }
    }
    // }
    ?>

<?php
} else {
    echo '<meta http-equiv="refresh" content="0;URL=index.php?page=faculty"/>';
}
?>