<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        /* CSS cho phần comment */
        .comment {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        /* CSS cho phần chat */
        .right-panel {
            width: 45%;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Khoảng cách giữa phần contribution và phần chat */
        }

        body {
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .left-panel,
        .right-panel {
            flex: 1;
            padding: 20px;
        }

        .left-panel {
            background-color: #f0f0f0;
        }

        .right-panel {
            background-color: #e0e0e0;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            color: #333333;
            font-size: 24px;
            margin: 0;
        }

        .download-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .download-btn:hover {
            background-color: #45a049;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .comment {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
        }

        /* Input and button styles */
        input[type="text"],
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: calc(100% - 80px);
        }

        button {
            background-color: #3498db;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Chat box styles */
        .chat-box {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .chat-box p {
            margin: 10px 0;
        }

        .chat-input {
            display: flex;
        }

        .chat-input input[type="text"] {
            flex: 1;
            margin-right: 10px;
        }

        .chat-input button {
            flex-shrink: 0;
        }


        .btnUpdateSta {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            /* Màu nền của nút */
            color: #fff;
            /* Màu chữ của nút */
            text-decoration: none;
            /* Loại bỏ gạch chân khi hover */
            border: none;
            /* Loại bỏ viền */
            border-radius: 5px;
            /* Bo tròn các góc */
            cursor: pointer;
            /* Đổi con trỏ khi hover */
        }

        /* Hover style */
        .btnUpdateSta:hover {
            background-color: #0056b3;
            /* Màu nền hover */
        }

        .chat-container {
            width: 90%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        #chat-box {
            height: 300px;
            overflow-y: scroll;

        }

        .stylemessage {
            display: flex;
        }

        .yourmessage {
            background-color: #f2f2f2;
            padding: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            border-radius: 3px;
            margin-right: auto;
        }

        .mymessage {
            background-color: #86d6e3;
            padding: 10px;
            margin-right: 20px;
            margin-bottom: 10px;
            border-radius: 3px;
            margin-left: auto;
        }

        #chat-form {
            margin-top: 10px;
        }

        #chat-form input[type="text"] {
            width: 70%;
            padding: 8px;
        }

        #chat-form button {
            width: 28%;
            padding: 8px;
        }
    </style>
</head>

<?php
include_once("connection.php");
$currentDate = date('Y-m-d');
// Kiểm tra xem có ID đóng góp được chọn không
if (isset($_GET['id'])) {
    $contributionID = $_GET['id'];

    // Truy vấn để lấy thông tin của đóng góp dựa trên ContributionID
    $sql = "SELECT * FROM contributions WHERE ContributionID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind ID vào câu truy vấn
        $stmt->bind_param("i", $contributionID);
        // Thực thi câu truy vấn
        $stmt->execute();
        // Lấy kết quả
        $result = $stmt->get_result();
        // Kiểm tra xem có dữ liệu trả về không
        if ($result->num_rows > 0) {
            // Lấy dữ liệu từ kết quả
            $row = $result->fetch_assoc();
            $title = $row['Title'];
            $content = $row['ContentP'];
            $fileP = $row['FileP'];
            $imgCv = $row['ImgCv'];
            $status = $row['Status'];
            $academicYear = $row['YearID'];
            $submitdate = $row['SubmissionDate'];


            // Thêm link PDF (điều chỉnh theo yêu cầu của bạn)
            $pdfLink = "download.php?file=example.pdf";
        }
    }
}

// Initialize the success message variable
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle feedback submission
    if (isset($_POST['feedback'])) {
        $feedbackValue = $_POST['feedback'];
        // Insert feedback into the database or process as needed
        $insertQuery = "INSERT INTO comments (ContributionID, Comment, CommentDate, UserID) VALUES (?, ?, NOW(), ?)";
        $stmt = $conn->prepare($insertQuery);
        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("isi", $contributionID, $feedbackValue, $userID);
            $contributionID = $_GET['id']; // Assuming you get it from the URL
            if (isset($_SESSION['id'])) {
                $userID = $_SESSION['id'];
            } // Assuming you store user ID in session after login
            if ($stmt->execute()) {
                // Feedback inserted successfully
                $success_message = "Feedback submitted successfully!";
            } else {
                // Error occurred while inserting feedback
                $success_message = "Error: " . $stmt->error;
            }
            // Close statement
            $stmt->close();
        } else {
            // Error preparing statement
            $success_message = "Error: " . $conn->error;
        }
    }
}
?>

<body>
    <form method="POST">
        <input type="hidden" id="selectedStatusInput" name="selectedStatus" value="<?php echo htmlspecialchars($status); ?>">
        <!-- Các phần còn lại của form -->
        <div class="container">
            <!-- Role của student -->
            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            ?>
                <div class="left-panel">
                    <!-- H2 và nút download cùng một dòng -->
                    <div class="header">
                        <h2 style="display: inline;">Contributions</h2>
                        <a class="download-btn" href="<?php echo $pdfLink; ?>" download style="display: inline; float: right;">Download PDF</a>
                    </div>

                    <!-- Thông tin từ bảng contributions -->
                    <p><strong>Title:</strong> <?php echo $title; ?></p>
                    <p><strong>Content:</strong> <?php echo $content; ?></p>
                    <p><strong>File:</strong> <?php echo $fileP; ?></p>
                    <p><strong>Submit Date:</strong> <?php echo $submitdate ?></p>
                    <?php
                    $acaYearId = $academicYear;
                    $acaYearQuery = mysqli_query($conn, "SELECT AcaYear FROM academicyear WHERE YearID = $acaYearId");
                    $acaYearData = mysqli_fetch_array($acaYearQuery);
                    $academicYear = $acaYearData["AcaYear"];
                    ?>
                    <p><strong>Academic Year:</strong> <?php echo $academicYear; ?></p>

                    <div class="dropdown">

                        <div class="dropdown">
                            <?php if (empty($status)) { ?>
                                <button class="dropbtn" id="selectedStatus" name="selectedStatus">Considering...</button>
                            <?php } else { ?>
                                <p><strong>Status:</strong> <?php echo $status; ?></p>
                            <?php } ?>
                        </div>
                        <?php
                        if ($row['Status'] == "Approve") {
                            echo '<br>';
                        } else {
                            echo '<a style="display: block;" href="?page=update_contri&id=' . $contributionID . '" class="btnUpdateSta" id="btnUpdateSta">Update Your Contribution</a>';
                        }

                        ?>
                    </div>
                </div>
                <!-- Role của coordi -->
            <?php
            } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 3) {
            ?>
                <div class="left-panel">

                    <!-- H2 và nút download cùng một dòng -->
                    <div class="header">
                        <h2 style="display: inline;">Contributions</h2>
                        <a class="download-btn" href="<?php echo $pdfLink; ?>" download style="display: inline; float: right;">Download PDF</a>
                    </div>
                    <!-- Thông tin từ bảng contributions -->
                    <p><strong>Title:</strong> <?php echo $title; ?></p>
                    <p><strong>Content:</strong> <?php echo $content; ?></p>
                    <p><strong>File:</strong> <?php echo $fileP; ?></p>
                    <p><strong>Submit Date:</strong> <?php echo $submitdate ?></p>
                    <p><strong>Content:</strong> <?php echo $content; ?></p>
                    <div class="dropdown">
                        <?php if (empty($status)) { ?>
                            <button class="dropbtn" id="selectedStatus" name="selectedStatus">Status</button>
                            <div class="dropdown-content">
                                <a href="#" onclick="changeStatus('Approve')">Approve</a>
                                <a href="#" onclick="changeStatus('Reject')">Reject</a>
                            </div>
                        <?php } else { ?>
                            <button class="dropbtn" id="selectedStatus" name="selectedStatus"><?php echo $status; ?></button>
                            <div class="dropdown-content">
                                <a href="#" value="1" onclick="changeStatus('Approve')">Approve</a>
                                <a href="#" value="2" onclick="changeStatus('Reject')">Reject</a>
                            </div>
                        <?php } ?>
                    </div>
                    <button type="submit" name="btnUpdateSta" id="btnUpdateSta" value="UpdateStatus">Update</button>


                </div>
            <?php } ?>

            <!-- Role của student -->

            <div class="right-panel">
                <!-- chat -->
                <div class="chat-container">
                    <div id="chat-box">
                        <?php
                        $sql = "SELECT SubmissionDate FROM contributions WHERE ContributionID = $contributionID";
                        $result = mysqli_query($conn, $sql);

                        // Kiểm tra xem có kết quả trả về không
                        if (mysqli_num_rows($result) > 0) {
                            // Lặp qua mỗi hàng kết quả
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Lấy SubmissionDate từ hàng hiện tại
                                $submissionDate = $row["SubmissionDate"];

                                // Tính số ngày chênh lệch giữa ngày hiện tại và SubmissionDate
                                $diff = strtotime($currentDate) - strtotime($submissionDate);
                                $daysDiff = floor($diff / (60 * 60 * 24));

                                // Kiểm tra nếu số ngày chênh lệch nhỏ hơn hoặc bằng 14
                                if ($daysDiff <= 14) {
                                    if ($conn->connect_error) {
                                        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
                                    }
                                    if (isset($_GET["id"])) {
                                        $id = $_GET["id"];
                                    }
                                    $sql = "SELECT * FROM chat WHERE ConID = $id";
                                    $result = $conn->query($sql);
                                    $usid = $_SESSION['id'];

                                    if ($result->num_rows > 0) {
                                        // Hiển thị dữ liệu
                                        while ($row = $result->fetch_assoc()) {
                                            if ($usid == $row["UserID"]) {
                                                echo "<div class='stylemessage'><div class='mymessage'>" . $row["Content"] . "</div></div>";
                                            } else {
                                                echo "<div class='stylemessage'><div class='yourmessage'>" . $row["Content"] . "</div></div>";
                                            }
                                        }
                                    } else {
                                        echo "Have not data!";
                                    }
                                } else {
                                    echo "Cannot feedback after 14 days";
                                }
                            }
                        } else {
                            echo "0 results";
                        }
                        ?>
                    </div>
                    <?php
                    if ($daysDiff <= 14) {
                        echo '<form id="chat-form" action="" method="post">
                        <input type="text" name="content" id="content" placeholder="Type your message...">
                        <button type="submit">Send</button>
                        </form>';
                    } else {
                        echo '';
                    }
                    ?>

                </div>

                <?php
                // Kiểm tra kết nối
                if ($conn->connect_error) {
                    die("There are some problems when connect to database..." . $conn->connect_error);
                }
                // Lấy dữ liệu từ form
                if (isset($_POST['content'])) {
                    $content = $_POST['content'];

                    // Thêm dữ liệu vào cơ sở dữ liệu
                    $sql = "INSERT INTO chat (UserID, ConID, Content, cTime) VALUES ('$usid', '$id', '$content', NOW())";
                    if ($conn->query($sql) === TRUE) {
                        echo "<script>window.location = window.location.href;</script>";
                    } else {
                        echo "Lỗi: " . $sql . "<br>" . $conn->error;
                    }
                }
                ?>

            </div>

            <!-- Role của student -->
            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            ?> <div class="container" style=" margin-top:100px;">
                    <div class="bottom-panel">
                        <h2>Comments</h2>
                        <!-- Thực hiện truy vấn để lấy các comment cho ContributionID -->
                        <?php
                        $getCommentsQuery = "SELECT comments.*, users.UserName FROM comments INNER JOIN users ON comments.UserID = users.UserID WHERE ContributionID = $contributionID";
                        $commentsResult = $conn->query($getCommentsQuery);

                        if ($commentsResult->num_rows > 0) {
                            echo '<div id="comments">';
                            while ($commentRow = $commentsResult->fetch_assoc()) {
                                echo '<div class="comment">';
                                echo '<p><strong>User:</strong> ' . $commentRow['UserName'] . '</p>'; // Hiển thị UserName thay vì UserID
                                echo '<p><strong>Date:</strong> ' . $commentRow['CommentDate'] . '</p>';
                                echo '<p><strong>Comment:</strong> ' . $commentRow['Comment'] . '</p>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<p>No comments yet.</p>';
                        }
                        ?>
                    </div>

                </div>
            <?php

            } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 3) {
            ?>
                <?php

                // Kiểm tra xem có ID đóng góp được chọn không
                if (isset($_GET['id'])) {
                    $contributionID = $_GET['id'];

                    // Truy vấn để lấy thông tin của đóng góp dựa trên ContributionID
                    $sql = "SELECT SubmissionDate FROM contributions WHERE ContributionID = ?";
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        // Bind ID vào câu truy vấn
                        $stmt->bind_param("i", $contributionID);
                        // Thực thi câu truy vấn
                        $stmt->execute();
                        // Lấy kết quả
                        $result = $stmt->get_result();
                        // Kiểm tra xem có dữ liệu trả về không
                        if ($result->num_rows > 0) {
                            // Lấy dữ liệu từ kết quả
                            $row = $result->fetch_assoc();
                            $submissionDate = $row['SubmissionDate'];

                            // Tính khoảng thời gian từ ngày submission cho đến hiện tại
                            $currentDate = date('Y-m-d'); // Ngày hiện tại
                            $submissionTimestamp = strtotime($submissionDate);
                            $currentTimestamp = strtotime($currentDate);
                            $daysDiff = floor(($currentTimestamp - $submissionTimestamp) / (60 * 60 * 24));
                            // Kiểm tra nếu đã qua 14 ngày
                            if ($daysDiff > 14) {
                                // Nếu đã qua 14 ngày, ẩn phần add feedback và chat
                                echo "<script>
                        document.getElementById('chat-form').style.display = 'none';
                        document.getElementById('feedbackInput').style.display = 'none';
                      </script>";
                            }
                        }
                    }
                }

                ?>
                <div class="container" style=" margin-top:100px;">
                    <div class="bottom-panel">
                        <!-- Add Feedback section -->
                        <h2>Add Feedback</h2>
                        <div id="feedbackInput">
                            <form method="POST">
                                <?php
                                $sql = "SELECT SubmissionDate FROM contributions WHERE ContributionID = $contributionID";
                                $result = mysqli_query($conn, $sql);

                                // Kiểm tra xem có kết quả trả về không
                                if (mysqli_num_rows($result) > 0) {
                                    // Lặp qua mỗi hàng kết quả
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Lấy SubmissionDate từ hàng hiện tại
                                        $submissionDate = $row["SubmissionDate"];

                                        // Tính số ngày chênh lệch giữa ngày hiện tại và SubmissionDate
                                        $diff = strtotime($currentDate) - strtotime($submissionDate);
                                        $daysDiff = floor($diff / (60 * 60 * 24));

                                        // Kiểm tra nếu số ngày chênh lệch nhỏ hơn hoặc bằng 14
                                        if ($daysDiff <= 14) {
                                            echo '<div id="feedbackInput">
                                                              <form method="POST">
                                                                  <input type="text" name="feedback" placeholder="Enter feedback...">
                                                                  <button type="submit">Submit Feedback</button>
                                                              </form>
                                                          </div>';
                                        } else {
                                            echo "Cannot feedback after 14 days";
                                        }
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>
                            </form>
                        </div>
                        <!-- Display success message if feedback submitted successfully -->
                        <?php if ($success_message !== "") { ?>
                            <div class="success-message"><?php echo $success_message; ?></div>
                        <?php } ?>
                        <?php
                        // Truy vấn để lấy các comment cho contribution tương ứng
                        $getCommentsQuery = "SELECT comments.*, users.UserName FROM comments INNER JOIN users ON comments.UserID = users.UserID WHERE ContributionID = $contributionID";
                        $commentsResult = $conn->query($getCommentsQuery);

                        if ($commentsResult->num_rows > 0) {
                            echo '<div id="comments">';
                            while ($commentRow = $commentsResult->fetch_assoc()) {
                                echo '<div class="comment">';
                                echo '<p><strong>UserID:</strong> ' . $commentRow['UserID'] . '</p>';
                                echo '<p><strong>UserName:</strong> ' . $commentRow['UserName'] . '</p>'; // Hiển thị UserName
                                echo '<p><strong>Date:</strong> ' . $commentRow['CommentDate'] . '</p>';
                                echo '<p><strong>Comment:</strong> ' . $commentRow['Comment'] . '</p>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        ?>


                        <script>
                            function toggleFeedbackInput() {
                                var feedbackInput = document.getElementById('feedbackInput');
                                if (feedbackInput.style.display === 'none') {
                                    feedbackInput.style.display = 'block';
                                } else {
                                    feedbackInput.style.display = 'none';
                                }
                            }
                            // Check if the Add Feedback button was clicked
                            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) { ?>
                                document.addEventListener("DOMContentLoaded", function() {
                                    document.getElementById('feedbackInput').style.display = 'block';
                                });
                            <?php } ?>
                        </script>
                    </div>
                </div>
            <?php
            }
            ?>
    </form>
</body>

<?php
if (isset($_POST["btnUpdateSta"])) {
    $status = $_POST["selectedStatus"];


    $err = "";
    if (trim($contributionID) == "") {
        $err .= "<li>Status update failed.1</li>";
    } else {
        $sq = "Select * from contributions where ContributionID = '$contributionID'";
        $result = mysqli_query($conn, $sq);
        if (mysqli_num_rows($result) == 1) {
            $sqlstring = "UPDATE contributions set Status='$status'
                     WHERE ContributionID='$contributionID'";
            mysqli_query($conn, $sqlstring);
            echo '<script>window.location.href = "index.php?page=interact&id=' . $contributionID . '";</script>';
            echo "Success";
        } else {
            echo "<li>Status update failed.2</li>";
        }
    }
} else {
    //echo '<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
}
?>

</html>
<script>
    function changeStatus(status) {
        document.getElementById('selectedStatus').innerText = status;
        document.getElementById('selectedStatusInput').value = status;
    }

    function toggleFeedbackInput() {
        var feedbackInput = document.getElementById('feedbackInput');
        if (feedbackInput.style.display === 'none') {
            feedbackInput.style.display = 'block';
        } else {
            feedbackInput.style.display = 'none';
        }
    }
</script>