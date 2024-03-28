<link rel="stylesheet" href="./Css/addform.css">

<?php
include_once("connection.php");
function bind_Category($conn)
{
    $sqlstring = "SELECT Cat_ID, Cat_Name FROM category";
    $result = mysqli_query($conn, $sqlstring);
    echo "<select name='CategoryList'>
				<option value ='0'>Choose Category</option>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<option value='" . $row['Cat_ID'] . "'>" . $row['Cat_Name'] . "</option>";
    }
    echo "</select>";
}

$sqlstudentid = "SELECT UserID FROM users WHERE Username = '" . $_SESSION["us"] . "'";
$result = mysqli_query($conn, $sqlstudentid);
$row = mysqli_fetch_assoc($result);
$id = $row['UserID'];


if (isset($_POST["btnAdd"])) {
    $id = $row['UserID'];
    $title = $_POST["txtTitle"];
    $content = $_POST["txtContentP"];
    $file = $_FILES["txtFile"];
    $cv = $_FILES["txtCv"];
    $sample = $_FILES['txtSample'];
    $currentDateTime = date('Y-m-d H:i:s');
    $err = "";

    // Kiểm tra điều kiện rỗng
    if (trim($title) == "") {
        $err .= "<li>Enter Title </li>";
    }

    if ($err != "") {
        echo "<ul>$err</ul>";
    } else {
        // Xử lý tệp tin được tải lên
        if ($cv['error'] == UPLOAD_ERR_OK && $file['error'] == UPLOAD_ERR_OK && $sample['error'] == UPLOAD_ERR_OK) {
            copy($cv['tmp_name'], "img/cv/" . $cv['name']);
            copy($file['tmp_name'], "Article/" . $file['name']);
            copy($sample['tmp_name'], "img/sample/" . $sample['name']);
            $fileC = $file['name'];
            $fileCv = $cv['name'];
            $filespl = $sample['name'];

            // Thực hiện truy vấn INSERT
            $sqlstring = "INSERT INTO contributions (Title, ContentP, StudentID, SubmissionDate, FileP, ImgCV, ImgSample)
                          VALUES ('$title', '$content', '$id', '$currentDateTime', '$fileC', '$fileCv', '$filespl')";
            mysqli_query($conn, $sqlstring);
            echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
        } else {
            echo "Error uploading file!";
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
                        <input type="file" id="txtFile" name="txtFile" style="margin-top: 10px;" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="">Image Cover</label>
                    </div>
                    <div class="col-75">
                        <input type="file" id="txtCv" name="txtCv" style="margin-top: 10px;" value="" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="">Image Sample</label>
                    </div>
                    <div class="col-75">
                        <input type="file" id="txtSample" name="txtSample" style="margin-top: 10px;" value="" />
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