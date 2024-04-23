<style>
    /* Thiết lập font chữ mặc định */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Thiết lập các kiểu nút */
    .button {
        background-color: #4CAF50;
        /* Màu nền */
        border: none;
        /* Không có đường viền */
        color: white;
        /* Màu chữ */
        padding: 10px 20px;
        /* Kích thước nút */
        text-align: center;
        /* Canh giữa chữ trong nút */
        text-decoration: none;
        /* Không gạch chân chữ */
        display: inline-block;
        font-size: 16px;
        /* Cỡ chữ */
        margin: 4px 2px;
        cursor: pointer;
    }

    /* Khi rê chuột qua nút */
    .button:hover {
        background-color: #45a049;
        /* Màu nền thay đổi khi rê chuột qua */
    }

    /* Bảng */
    table {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    /* Tiêu đề cột */
    th {
        background-color: #4CAF50;
        /* Màu nền tiêu đề */
        color: white;
        /* Màu chữ */
        text-align: left;
        /* Canh lề trái */
        padding: 8px;
    }

    /* Dòng trong bảng */
    td {
        border-bottom: 1px solid #ddd;
        /* Đường viền dưới cho từng ô */
        padding: 8px;
    }

    /* Khi rê chuột qua dòng trong bảng */
    tr:hover {
        background-color: #f5f5f5;
        /* Màu nền thay đổi khi rê chuột qua */
    }

    /* Căn chỉnh hình ảnh */
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width: 100px;
        /* Kích thước tối đa của hình ảnh */
        max-height: 100px;
    }
</style>
<?php
// Thêm vào đầu file để có thể sử dụng các hàm date
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ mặc định

include_once("connection.php");

// Start the session if using session variables
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define $currentDate to get the current Unix timestamp
$currentDate = time();

if (isset($_GET["function"]) && $_GET["function"] == "del") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        // Kiểm tra closuredate
        $result = mysqli_query($conn, "SELECT ClosureDate FROM contributions WHERE ContributionID = $id");
        $row = mysqli_fetch_assoc($result);
        $closureDate = strtotime($row['ClosureDate']);

        // Nếu đã qua ngày hạn chót, không cho phép xóa
        if ($currentDate > $closureDate) {
            echo "<script>alert('Cannot delete after closure date.')</script>";
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=studentsubmit"/>';
            exit();
        }

        // Nếu chưa qua hạn, tiếp tục xử lý xóa
        // First, delete comments related to the contribution
        $sql_delete_comments = "DELETE FROM comments WHERE ContributionID='$id'";
        if (!mysqli_query($conn, $sql_delete_comments)) {
            echo "Error deleting comments: " . mysqli_error($conn);
            exit(); // Stop further execution if an error occurs
        }

        // Then, delete chats related to the contribution
        $sql_delete_chats = "DELETE FROM chat WHERE ConID='$id'";
        if (!mysqli_query($conn, $sql_delete_chats)) {
            echo "Error deleting chats: " . mysqli_error($conn);
            exit(); // Stop further execution if an error occurs
        }

        // Finally, delete the contribution itself
        $sql_delete_contribution = "DELETE FROM contributions WHERE ContributionID='$id'";
        if (mysqli_query($conn, $sql_delete_contribution)) {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=studentsubmit"/>';
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}
?>

<br>
<div class="container1">

    <div>
        <a href="?page=add_contri"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>

        <a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

    </div>
    <table style="width:100%">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Title</th>
                <th>ContentP</th>
                <th>SubmissionDate</th>
                <th>AcaYear</th>
                <th>Status</th>
                <th>FileP</th>
                <th>Image CV</th>
                <th>Edit</th>
                <th>Detail</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once("connection.php");
            $No = 1;
            $id = $_SESSION["id"];
            if (isset($_GET["function"]) && $_GET["function"] == "del") {
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];

                    // Kiểm tra closuredate
                    $result_closure = mysqli_query($conn, "SELECT ClosureDate FROM contributions WHERE ContributionID = $id");
                    $row_closure = mysqli_fetch_assoc($result_closure);
                    $closureDate = strtotime($row_closure['ClosureDate']);
                    $currentDate = time();

                    // Nếu đã qua ngày hạn chót, không cho phép xóa
                    if ($currentDate > $closureDate) {
                        echo "<script>alert('Cannot delete after closure date.')</script>";
                        echo '<meta http-equiv="refresh" content="0;URL=index.php?page=studentsubmit"/>';
                        exit();
                    }

                    // Nếu chưa qua hạn, tiếp tục xử lý xóa
                    // First, delete comments related to the contribution
                    $sql_delete_comments = "DELETE FROM comments WHERE ContributionID='$id'";
                    if (!mysqli_query($conn, $sql_delete_comments)) {
                        echo "Error deleting comments: " . mysqli_error($conn);
                        exit(); // Stop further execution if an error occurs
                    }

                    // Then, delete chats related to the contribution
                    $sql_delete_chats = "DELETE FROM chat WHERE ConID='$id'";
                    if (!mysqli_query($conn, $sql_delete_chats)) {
                        echo "Error deleting chats: " . mysqli_error($conn);
                        exit(); // Stop further execution if an error occurs
                    }

                    // Finally, delete the contribution itself
                    $sql_delete_contribution = "DELETE FROM contributions WHERE ContributionID='$id'";
                    if (mysqli_query($conn, $sql_delete_contribution)) {
                        echo '<meta http-equiv="refresh" content="0;URL=index.php?page=studentsubmit"/>';
                    } else {
                        echo "Error deleting record: " . mysqli_error($conn);
                    }
                }
            }

            // Fetch contributions
            $result = mysqli_query($conn, "SELECT * FROM contributions WHERE UserID = $id");
            while ($row = mysqli_fetch_array($result)) {
                // Display contribution details
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $row["UserID"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["Title"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["ContentP"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["SubmissionDate"]; ?></td>
                    <td style="text-align: center;"><?php
                                                    // Lấy năm từ bảng academicyear dựa trên ID
                                                    $acaYearId = $row["YearID"];
                                                    $acaYearQuery = mysqli_query($conn, "SELECT AcaYear FROM academicyear WHERE YearID = $acaYearId");
                                                    $acaYearData = mysqli_fetch_array($acaYearQuery);
                                                    echo $acaYearData["AcaYear"];
                                                    ?></td>
                    <td style="text-align: center;"><?php echo $row["Status"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["FileP"]; ?></td>
                    <td style="text-align: center;"><img style="width:100px; height:100px" src="./Img/<?php echo $row["ImgCv"]; ?>" alt="Image"></td>
                    <td style='text-align:center'>
                        <?php
                        // Define the default value of $disableEdit
                        $disableEdit = '';
                        // Retrieve closure date from the database
                        $closureDateQuery = mysqli_query($conn, "SELECT closureDate FROM academicyear WHERE YearID = $acaYearId");
                        $closureDateRow = mysqli_fetch_assoc($closureDateQuery);
                        $closureDate = strtotime($closureDateRow['closureDate']);

                        // Check if submission date is after closure date
                        if ($currentDate > $closureDate) {
                            // Set $disableEdit to 'disabled' to disable the edit button
                            $disableEdit = 'disabled';
                        }

                        if ($disableEdit == 'disabled') {
                            // Nếu submissiondate > closuredate, vô hiệu hóa nút chỉnh sửa
                            echo '<a style="color: gray; text-decoration: none; pointer-events: none;">&#9998;</a>';
                        } else {
                            // Ngược lại, hiển thị nút chỉnh sửa
                            echo '<a href="?page=update_contri&&id=' . $row["ContributionID"] . '" style="color: green; text-decoration: none;">&#9998;</a>';
                        }
                        ?>
                    </td>
                    <td style='text-align:center'>
                        <a href="?page=interact&&id=<?php echo $row["ContributionID"]; ?>" style="color: green; text-decoration: none;">
                            &#9998;</a>
                    </td>
                    <td style='text-align:center'>
                        <a href="mysubmit.php?function=del&id=<?php echo $row["ContributionID"]; ?>" style="color: red; text-decoration: none;" onclick="return deleteConfirm()">❌</a>
                    </td>
                </tr>
            <?php
                $No++;
            }
            ?>
        </tbody>
    </table>
    <h2></h2>
</div>