<?php
include_once("connection.php");
    //get data from db
    $query = " SELECT * From users where Username = '" .$_SESSION["us"]. "'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $us = $_SESSION["us"];
    $name = $row["fullName"];
    $mail = $row["Email"];
    $tel = $row["Phone"];
    $address = $row["Address"];


    //update
    if(isset($_POST["btnUpdate"])){
        $name = $_POST["txtName"];
        $tel = $_POST["txtPhone"];
        $address = $_POST["txtAdd"];
        $mail = $_POST["txtMail"];

        $test = check();
        if($test==""){
            $sq = "UPDATE users SET fullName='$name' , Address='$address', Email='$mail',
                            Phone='$tel' WHERE Username = '$us'";
            mysqli_query($conn,$sq) or die(mysqli_error($conn));   
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';
 
        }else{     
           echo $test;     
        }
    }

    function check(){
        if($_POST['txtName']==""||$_POST['txtAdd']==""||$_POST['txtPhone']==""){
            return "<li>Enter information fully</li>";
        }else{
            return "";
        }
    }

?>
<style>
.btn_back{
    margin-top: 10px;
    text-decoration: none; 
    color:black; 
    text-align:center;
}
.btn_back:hover{
    text-shadow: 0px 1px 10px #000000;
    color: rgb(0, 0, 0);
}
input.btnUpd{
    font-weight: bold;
    background-color: 	#3CB371	;
}
input.btnUpd:hover{
    background-color: 	#90EE90;
}
.lblTitle{
    font-weight: bold;
    padding-bottom: 5px;
}
</style>

<div class="container">
    <form action="" method="POST">
        <div class="form">
          <h2>ACOUNT</h2>
        <div class="acinf" >
            <label style="float: left;" for="" class="lblTitle"> User Name</label>
            <input type="text" value=<?php echo $us?> readonly>
         </div>
        <div class="acinf">
            <label style="float: left;" for=""class="lblTitle"> Full Name</label>
            <input type="text" id="txtName" name="txtName" value="<?php echo $name?>">
         </div>
        <div class="acinf">
            <label style="float: left;" for=""class="lblTitle"> Mail</label>
            <input type="text" id="txtMail" name="txtMail" value="<?php echo $mail?>">
        </div>
        <div class="acinf">
            <label style="float: left;" for=""class="lblTitle"> Phone</label>
            <input type="text" name="txtPhone" id="txtPhone"  value="<?php echo $tel?>">
        </div>
        <div class="acinf">
            <label style="float: left;" for=""class="lblTitle"> Address</label>
            <input type="text" name="txtAdd" id="txtAdd"  value="<?php echo $address?>">
        </div>
        
        <input type="submit" class="btnUpd" name="btnUpdate" id="btnUpdate" value="UPDATE">
        <a href="?page=home" class="btn_back"><span>Back &#10148; </span></a>
        </div>
    </form>
    
</div>