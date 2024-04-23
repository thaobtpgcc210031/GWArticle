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


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sqlstring = "Select * From academicyear where YearID='$id'";
    $result = mysqli_query($conn, $sqlstring);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $aca = $row["AcaYear"];  
    $clo = $row["closureDate"];
    $fclo = $row['fclosureDate'];
    // $closure = $row["ClosureDate"];
    // $finalclo = $row["FinalClosureDate"];

?>


    <br>
    <div class="container1">
        <div>
            <p style="margin-bottom: 10px; margin-left: 20px;">UDATE ACADEMIC YEAR</p>
            <div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-25">
                            <label for="">ID</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtID" name="txtID" readonly value='<?php echo $id; ?>' placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="">ACADEMIC YEAR</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtaca" name="txtaca" value='<?php echo $aca; ?>' placeholder="Name of ...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="">CLOSURE DATE</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtclo" name="txtclo" value='<?php echo $clo; ?>' placeholder="Name of ...">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="">FINAL CLOSURE DATE</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtfclo" name="txtfclo" value='<?php echo $fclo; ?>' placeholder="Name of ...">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
                        <a href="?page=acayear" class="btn_back"><span>Back &#10148; </span></a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST["btnUpdate"])) {
        $aca = $_POST["txtaca"];
        $clo = $_POST["txtclo"];
        $fclo = $_POST["txtfclo"];
        // $publ = $_POST["txtPub"];
        // $conte = $_POST['txtCont'];
        // $closure = $_POST["txtClo"];
// $finalclo = $_POST["txtFClo"];


        $err = "";
        if (trim($id) == "") {
            $err .= "<li>Enter ID </li>";

        } else {
            $sq = "Select * from academicyear where YearID = '$id'";
            $result = mysqli_query($conn, $sq);
            if (mysqli_num_rows($result) == 1) {
                $sqlstring = "UPDATE academicyear set AcaYear='$aca',closureDate='$clo',fclosureDate='$fclo'
                     WHERE YearID='$id'";
                mysqli_query($conn, $sqlstring);
                echo '<meta http-equiv="refresh" content="0;URL=index.php?page=acayear"/>';
            } else {
                echo "<li>ERROR</li>";
            }
        }
    }
    // }
    ?>

<?php
} else {
    echo '<meta http-equiv="refresh" content="0;URL=index.php?page=acayear"/>';
}
?>