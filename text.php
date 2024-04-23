<!DOCTYPE html>
<html>

<head>
    <title>Add Contribution</title>
</head>

<body>
    <?php
    // Start session
    //session_start();

    // Set timezone
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    // Include database connection
    include_once("connection.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    // Function to send email
    function sendEmail($userName, $academicYear, $email)
    {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Mailer = "smtp";
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'thaobtpgcc210031@fpt.edu.vn'; // Your SMTP username
            $mail->Password = 'lyxuklvtdwwmtuvz'; // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            // Sender
            $mail->setFrom('thaobtpgcc210031@fpt.edu.vn', 'Mailer'); // Your email and name

            // Recipient
            $mail->addAddress($email); // Recipient's email
            $mail->CharSet = "UTF-8";
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Contribution Added';
            $mail->Body = "Hello $userName, <br><br>
                        Your contribution has been successfully added. <br>
                        Details:<br>
                        - User Name: $userName<br>
                        - Academic Year: $academicYear<br><br>
                        Thank you.";
            $mail->send();
            echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    // Function to bind Category List
    function bind_Category_List($conn)
    {
        $sqlstring = "SELECT YearID, AcaYear FROM academicyear";
        $result = mysqli_query($conn, $sqlstring);
        echo "<select name='YearID' class='form-control'>
        <option value='0'>Please Choose Academic Year</option>";
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<option value='" . $row['YearID'] . "'>" . $row['AcaYear'] . "</option>";
        }
        echo "</select>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["btnAdd"])) {
            // Check if user is logged in
            if (!isset($_SESSION["us"])) {
                // Redirect to login page if user is not logged in
                header("Location: login.php");
                //exit;
            }

            // Get form data
            $userID = $_SESSION["id"];
            $annualMagazineID = $_POST["YearID"];
            $articleTitle = $_POST["Title"];
            $submissionDate = date('Y-m-d H:i:s');
            $file = $_FILES["FileP"];
            $pic = $_FILES["ImgCv"];
            if ($_FILES["FileP"]["type"] == "application/pdf") {
                echo '<script>alert("You must import the file docx.");</script>';
                // Redirect or display message here
            } 

            // Check if user has agreed to terms
            $agree = filter_input(INPUT_POST, 'agree', FILTER_SANITIZE_STRING);
            if (!$agree) {
                echo '<script>alert("You need to agree to the terms.");</script>';
                echo '<meta http-equiv="refresh" content="0;URL=?page=add_contri"/>';
                exit;
            }

            // Validate and process file uploads
            if (in_array($pic["type"], ["image/jpg", "image/jpeg", "image/png", "image/gif"]) && $pic["size"] <= 2097152) { // 2MB
                if ($file["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && $file["size"] <= 2097152) { // 2MB
                    // Check if article already exists
                    $sql = "SELECT * FROM academicyear WHERE YearID = '$annualMagazineID' AND DATE_FORMAT(closureDate, '%Y') = DATE_FORMAT('$submissionDate', '%Y')";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        // Check if submissionDate falls within the selected academicYear
                        // Lấy năm của submissionDate
                        $submissionYear = date('Y', strtotime($submissionDate));

                        // Tạo truy vấn SQL với submissionYear thay thế cho '2024'
                        $sql_check_academic_year = "SELECT COUNT(*) AS count FROM academicyear WHERE AcaYear = '$submissionYear' AND DATE_FORMAT(closureDate, '%Y') = '$submissionYear'";
                        $result_check_academic_year = mysqli_query($conn, $sql_check_academic_year);
                        $row_check_academic_year = mysqli_fetch_assoc($result_check_academic_year);
                        if ($row_check_academic_year['count'] > 0) {
                            // Get the roleID of the current login account from session
                            //$role_id_dang_nhap = $_SESSION['roleID'];

                            // SQL query to get facultyID from the user table based on the roleID of the login account
                            $sql_faculty = "SELECT depart FROM users WHERE role =" . $_SESSION['role'];
                            $result_faculty = mysqli_query($conn, $sql_faculty);
                            $row_faculty = mysqli_fetch_assoc($result_faculty);
                            $faculty_id = $row_faculty['depart'];

                            // Continue querying to get email from user table with condition roleID = 3 and facultyID = $faculty_id
                            $sql_email = "SELECT Email FROM users WHERE Role = 3 AND depart =" . $_SESSION['depart'];
                            $result_email = mysqli_query($conn, $sql_email);
                            $row_email = mysqli_fetch_assoc($result_email);
                            $email = $row_email['Email'];

                            // Check to see if any results are returned
                            if ($email) {
                                // Validate submissionDate against finalClosureDate
                                $sql_check_date = "SELECT fclosureDate FROM academicyear WHERE YearID = '$annualMagazineID'";
                                $result_check_date = mysqli_query($conn, $sql_check_date);
                                $row_check_date = mysqli_fetch_assoc($result_check_date);
                                $finalClosureDate = $row_check_date['fclosureDate'];

                                if (strtotime($submissionDate) > strtotime($finalClosureDate)) {
                    
                                    echo '<script type="text/javascript"> window.onload = function () 
                                    { 
                                         alert("Submission date cannot be after final closure date.");
                                    }
                                     </script>';
                                        echo '<meta http-equiv="refresh" content="0;URL=?page=add_contri"/>';
                                        exit;
                                }

                                // Generate unique filenames
                                $pictureName = uniqid('', true) . '_' . $pic['name'];
                                $docxName = uniqid('', true) . '_' . $file['name'];

                                // Move uploaded files to appropriate directories
                                move_uploaded_file($pic['tmp_name'], "Img/" . $pictureName);
                                move_uploaded_file($file['tmp_name'], "uploads/" . $docxName);

                                // Escape and sanitize data
                                $articleTitleen = htmlspecialchars(mysqli_real_escape_string($conn, $articleTitle));
                                $picture = htmlspecialchars(mysqli_real_escape_string($conn, $pictureName));
                                $docxFile = htmlspecialchars(mysqli_real_escape_string($conn, $docxName));

                                // Insert contribution into database
                                $sqlstring = "INSERT INTO contributions (id, YearID, SubmissionDate, Title, FileP, ImgCv, Status) 
                                    VALUES ('$userID', '$annualMagazineID','$submissionDate','$articleTitleen','$docxFile','$picture','0')";
                                mysqli_query($conn, $sqlstring) or die(mysqli_error($conn));

                                // Send email notification
                                if (sendEmail($_POST['Username'], $_POST['AcaYear'], $email)) {
                                    echo '<script>alert("Contribution added successfully. Email sent.");</script>';
                                } else {
                                    echo '<script>alert("Contribution added successfully. Failed to send email.");</script>';
                                }

                                // Redirect to contribution index page
                                echo '<meta http-equiv="refresh" content = "0; URL=?page=contribution"/>';
                                exit;
                            } else {
                                echo '<script type="text/javascript"> window.onload = function () 
                                    { 
                                         alert("Email not found for the specified role and faculty");
                                    }
                                     </script>';
                                        echo '<meta http-equiv="refresh" content="0;URL=?page=add_contri"/>';
                                        exit;
                            }
                        } else {
                            echo '<script type="text/javascript"> window.onload = function () 
                                    { 
                                         alert("Article with the same title or submission date already exists");
                                    }
                                     </script>';
                                        echo '<meta http-equiv="refresh" content="0;URL=?page=add_contri"/>';
                        }
                    } else {
                        echo "Submission date does not fall within the selected academic year.";
                    }
                } else {
                    echo "Invalid .docx file format or size is too big.";
                }
            } else {
                echo "Invalid image file format or size is too big.";
            }
        }
    }

    ?>


    <div class="my-3">
        <div class="p-5 border">
            <img src="./img/company_logo.png" alt="Company Logo" height="50%" width="15%">
            <h2 class="text-center mb-4">Adding Contribution</h2>

            <form id="frmcontributionAdd" name="ContributionID" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return formValid()">
                <div class="form-group" style="margin-left: 0%;">
                    <label for="id">Academic Year</label>
                    <div>
                        <?php bind_Category_List($conn); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Title">Article Title</label>
                    <input type="text" name="Title" id="Title" class="form-control" placeholder="" value='<?php echo isset($_POST["Title"]) ? ($_POST["Title"]) : ""; ?>' />
                </div>

                <div class="form-group">
                    <label for="Username">User Name</label>
                    <input type="text" name="Username" id="Username" class="form-control" value='<?php echo isset($_POST["Username"]) ? ($_POST["Username"]) : ""; ?>' />
                </div>

                <div class="form-group">
                    <label for="SubmissionDate">Submission Date</label>
                    <input type="text" name="SubmissionDate" id="SubmissionDate" class="form-control" value="<?php echo date("H:i:s d/m/Y "); ?>" disabled />
                </div>

                <div class="form-group">
                    <label for="FileP">Upload .docx File</label>
                    <input type="file" name="FileP" id="FileP" class="form-control" accept=".docx" />
                </div>

                <div class="form-group">
                    <label for="ImgCv">Upload Image</label>
                    <input type="file" name="ImgCv" id="ImgCv" />
                </div>

                <div class="form-group text-center">
                    <label for="agree"> <input type="checkbox" name="agree" value="yes" id="agree" /> I agree to the <a href="?page=termcondition" title="">Term and Condition</a></label>
                    <input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
                    <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=add_contri'" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
