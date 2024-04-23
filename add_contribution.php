<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contribution</title>
    <style>
        /* Reset some default styles */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Style for the container of the form */
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
        }

        /* Style for the heading */
        .container p {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Style for the form fields and labels */
        .row {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .col-25 {
            width: 25%;
        }

        .col-75 {
            width: 75%;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"] {
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Style for the submit button */
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Style for the back button */
        .btn_back {
            display: inline-block;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn_back:hover {
            background-color: #d32f2f;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .row {
                flex-direction: column;
            }

            .col-25,
            .col-75 {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once 'D:/web1001/htdocs/gicungduoc/atn/atn/PHPMailer/src/Exception.php';
require_once 'D:/web1001/htdocs/gicungduoc/atn/atn/PHPMailer/src/PHPMailer.php';
require_once 'D:/web1001/htdocs/gicungduoc/atn/atn/PHPMailer/src/SMTP.php';
include_once("connection.php");
    function sendEmail($userName, $title, $content, $academicYear, $email, $conn)
    {
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
$mail->Username   = 'thaobtpgcc210031@fpt.edu.vn';
            $mail->Password   = 'lyxuklvtdwwmtuvz';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom('thaobtpgcc210031@fpt.edu.vn', 'GW Article');
            $mail->addAddress($email);
            $mail->CharSet = "UTF-8";

            $mail->isHTML(true);
            $mail->Subject = 'GW ARTICLE';
            $mail->Body = "Hello Coordinator, this is a mail from $userName <br><br>
                        Contribution has been successfully added. <br>
                        Details:<br>
                        - Title: $title <br><br>
                        - Content: $content <br><br>
                        - Academic Year: " . getAcademicYearName($conn, $_POST['acayear']) . " ";
            $mail->AltBody = 'Thank you, have a nice day!';

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Failed to send email to: $email. Error: {$mail->ErrorInfo}<br>";
            return false;
        }
    }
    function getAcademicYearName($conn, $yearID)
{
    $sql = "SELECT AcaYear FROM academicyear WHERE YearID = '$yearID'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['AcaYear'];
    } else {
        return "N/A"; // Trả về giá trị mặc định nếu không tìm thấy năm học
    }
}


    function bind_aca($conn)
    {
        $sqlstring = "SELECT YearID, AcaYear FROM academicyear";
        $result = mysqli_query($conn, $sqlstring);
        echo "<select name='acayear'>
            <option value ='0'>Choose Academic Year</option>";
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<option value='" . $row['YearID'] . "'>" . $row['AcaYear'] . "</option>";
        }
        echo "</select>";
    }

    if (isset($_POST["btnAdd"])) {
        $id = $_SESSION["id"];
        $title = $_POST["txtTitle"];
        $content = $_POST["txtContentP"];
        $file = $_FILES["txtFile"];
        $cv = $_FILES["txtCv"];
        $aca = $_POST['acayear'];
        $err = "";

        if (empty($title)) {
            $err .= "<li>Please enter title.</li>";
        }

        if (empty($content)) {
            $err .= "<li>Please enter content.</li>";
        }

        if ($cv['error'] === UPLOAD_ERR_NO_FILE) {
            $err .= "<li>Please choose Image.</li>";
        }




        // Validate file types
        // Validate file types
        // Validate file types
        $allowedExtensions = array('docx', 'doc');
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            $err .= "<li>Please upload only Word documents (docx or doc).</li>";
        }
        $agree = filter_input(INPUT_POST, 'agree', FILTER_SANITIZE_STRING);
        if (!$agree) {
            echo '<script>alert("You need to agree to the terms.");</script>';
            echo '<meta http-equiv="refresh" content="0;URL=?page=add_contri"/>';
exit;
        }

        if ($aca  == "0") {
            $err .= "<li>Please choose Academic Year.</li>";
        }
        
// Define the current date
$currentDate = date('Y-m-d');

// Your existing PHP code goes here...

// Fetch the academic year based on the current date
$sql = "SELECT fclosureDate FROM academicyear WHERE closureDate <= '$currentDate' ORDER BY closureDate DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $finalClosureDate = $row['fclosureDate'];
} else {
    // Handle the case where the final closure date is not found
    $finalClosureDate = ''; // Set a default value or handle the error as per your requirement
}

// Use the final closure date in your validation logic
if (isset($_POST["btnAdd"])) {
    $submissionDate = $_POST["txtSubmissionDate"];
    if (strtotime($submissionDate) > strtotime($finalClosureDate)) {
        echo '<script>alert("Submission date cannot be after the final closure date.");</script>';
        
// Define the current date
$currentDate = date('Y-m-d');

// Your existing PHP code goes here...

// Fetch the academic year based on the current date
$sql = "SELECT fclosureDate FROM academicyear WHERE closureDate <= '$currentDate' ORDER BY closureDate DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $finalClosureDate = $row['fclosureDate'];
} else {
    // Handle the case where the final closure date is not found
    $finalClosureDate = ''; // Set a default value or handle the error as per your requirement
}

// Use the final closure date in your validation logic
if (isset($_POST["btnAdd"])) {
    $submissionDate = $_POST["txtSubmissionDate"];
    if (strtotime($submissionDate) > strtotime($finalClosureDate)) {
        echo '<script>alert("Submission date cannot be after the final closure date.");</script>';
        echo '<meta http-equiv="refresh" content="0;URL=?page=add_contri"/>';
        exit;
    }
}


    }
}



        if ($err != "") {
            echo "<ul>$err</ul>";
        } else {
            if ($cv['error'] == UPLOAD_ERR_OK && $file['error'] == UPLOAD_ERR_OK) {
                if (
                    move_uploaded_file($cv['tmp_name'], "Img/" . $cv['name']) &&
                    move_uploaded_file($file['tmp_name'], "uploads/" . $file['name'])
                ) {
                    $sqlstring = "INSERT INTO contributions (UserID ,Title, ContentP, SubmissionDate, FileP, ImgCv, YearID, Status)
                              VALUES ('$id','$title', '$content', NOW(), '{$file['name']}', '{$cv['name']}', '$aca', 'Considering')";
                    $result = mysqli_query($conn, $sqlstring);
                    if ($result) {
                        $sql_email = "SELECT Email FROM users WHERE Role = 3 AND depart =" . $_SESSION['depart'];
                        $result_email = mysqli_query($conn, $sql_email);
if ($result_email && mysqli_num_rows($result_email) > 0) {
                            while ($row_email = mysqli_fetch_assoc($result_email)) {
                                $email = $row_email['Email'];
                                sendEmail($_SESSION["us"], $title, $content, $aca, $email, $conn);
                            }
                        } else {
                            echo "No users found with role = 3 and depart = 1";
                        }

                        echo '<meta http-equiv="refresh" content="0;URL=?page=studentsubmit"/>';
                        exit;
                    } else {
                        echo "Error inserting data into database!";
                    }
                } else {
                    echo "Error uploading file!";
                }
            } else {
                echo "Error uploading files!";
            }
        }
    }
    ?>


    <!-- HTML FORM -->
    <br>
    <div class="container">
        <div>
            <p style="margin-bottom: 10px; margin-left: 20px;">ADD CONTRIBUTION</p>
            <div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-25">
                            <label for="txtTitle">Title</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtTitle" name="txtTitle" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="txtContentP">Content</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="txtContentP" name="txtContentP" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="txtFile">File (.docx or .doc)</label>
                        </div>
                        <div class="col-75">
                            <input type="file" id="txtFile" name="txtFile" style="margin-top: 10px;" accept=".docx, .doc" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="txtCv">Image Cover</label>
                        </div>
                        <div class="col-75">
                            <input type="file" id="txtCv" name="txtCv" style="margin-top: 10px;" value="" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="acayear">Academic Year</label>
                        </div>
                        <div class="col-75">
<?php bind_aca($conn); ?>
                        </div>
                    </div>


                    <div class="form-group text-center">
                        <label for="agree"> <input type="checkbox" name="agree" value="yes" id="agree" /> I agree to the <a href="?page=termcondition" title="">Term and Condition</a></label>
                    </div>
                    <br>
                    <div class="row">
                        <input type="submit" name="btnAdd" id="btnAdd" value="ADD">
                        <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=add_contri'" />
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>