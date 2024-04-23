<style>
/* Reset some default styles */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container1 {
    margin: 20px auto;
    width: 50%;
}

p {
    font-size: 24px;
    font-weight: bold;
    margin-left: 20px;
}

form {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
}

.row {
    margin-bottom: 20px;
}

.col-25 {
    float: left;
    width: 25%;
}

.col-75 {
    float: left;
    width: 75%;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

input[type=text] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.btn_back {
    background-color: #f44336;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.btn_back:hover {
    background-color: #d32f2f;
}


</style>
<link rel="stylesheet" href="./Css/addform.css">

<?php
include_once("connection.php");
if (isset($_POST["btnAdd"])) {
    $name = $_POST["txtName"];
    $des = $_POST["txtDes"];
    



    $err = "";
    if ($name == "") {
        $err .= "<li>Enter Name Of Faculty</li>";
    } else {
        $sq = "SELECT * FROM department where departmentName='$name'";
        $result = mysqli_query($conn, $sq);
        if (mysqli_num_rows($result) == 0) {
            mysqli_query($conn, "INSERT INTO department ( departmentName, DeDes)
				VALUES ('$name','$des')");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=faculty"/>';
        } else {
            echo "<li>Duplicate Name</li>";
        }
    }
}
?>


<br>
<div class="container1">
    <div>
        <p style="margin-bottom: 10px; margin-left: 20px;">ADD FACULTY</p>
        <div>
            <form action="" method="POST">
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