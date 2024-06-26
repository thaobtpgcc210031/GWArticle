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
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start(); // Bắt đầu output buffering

include_once("connection.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sqlstring = "SELECT * FROM department WHERE departmentID='$id'";
    $result = mysqli_query($conn, $sqlstring);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $maga = $row["departmentID"];
    $contri = $row["departmentName"];
    $aca = $row["DeDes"];
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
                            <label for="">Description</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtAca" name="txtAca" value='<?php echo $aca; ?>' placeholder="">
                        </div>
                    </div>
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
        if (trim($id) == "") {
            echo "Nhập ID";
        } else {
            $sqlstring = "UPDATE department SET departmentName='$contri', DeDes='$aca' WHERE departmentID='$id'";
            if (mysqli_query($conn, $sqlstring)) {
                echo '<meta http-equiv="refresh" content="0;URL=index.php?page=faculty"/>';
                echo "Update Successfully.";               
                exit();
            } else {
                echo "Lỗi khi cập nhật bản ghi: " . mysqli_error($conn);
            }
        }
    }
}
ob_end_flush(); // Flush và tắt output buffering
?>