<link rel="stylesheet" href="./Css/addform.css">

<?php
include_once("connection.php");
if (isset($_POST["btnAdd"])) {
    $id = $_POST["txtID"];
    $name = $_POST["txtName"];
    $des = $_POST["txtDes"];
    



    $err = "";
    if ($id == "") {
        $err .= "<li>Enter ID</li>";
    }
    if ($name == "") {
        $err .= "<li>Enter Name<li>";
    }
    if ($err != "") {
        echo "<ul>$err</ul>";
    } else {




        $id = htmlspecialchars(mysqli_real_escape_string($conn, $id));
        $name = htmlspecialchars(mysqli_real_escape_string($conn, $name));
        $des = htmlspecialchars(mysqli_real_escape_string($conn, $des));
        $sq = "SELECT * FROM department where departmentID='$id' or departmentName='$name'";
        $result = mysqli_query($conn, $sq);
        if (mysqli_num_rows($result) == 0) {
            mysqli_query($conn, "INSERT INTO department (departmentID, departmentName, DeDes)
				VALUES ('$id','$name','$des')");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=faculty"/>';
        } else {
            echo "<li>Duplicate Department ID or Name</li>";
        }
    }
}
?>


<br>
<div class="container1">
    <div>
        <p style="margin-bottom: 10px; margin-left: 20px;">ADD </p>
        <div>
            <form action="" method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">ID Faculty</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="txtID" name="txtID" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Faculty</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="txtName" name="txtName" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Description</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="txtDes" name="txtDes" placeholder="">
                    </div>
                </div>
                


                <br>
                <div class="row">
                    <input type="submit" name="btnAdd" id="btnAdd" value="ADD">
                    <a href="?page=faculty" class="btn_back"><span>Back &#10148; </span></a>
                </div>

            </form>
        </div>
    </div>
</div>