<?php
include_once("connection.php");

// Kiểm tra xem có ID đóng góp được chọn không
if(isset($_GET['id'])) {
    $contributionID = $_GET['id'];

    // Truy vấn để lấy thông tin của đóng góp dựa trên ContributionID
    $sql = "SELECT Title, ContentP, FileP, ImgCv, ImgSample FROM contributions WHERE ContributionID = ?";
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
            $imgSample = $row['ImgSample'];

            // Hiển thị form để chỉnh sửa thông tin
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Update Contribution</title>
            </head>
            <body>
                <h2>Update Contribution</h2>
                <form id="updateForm" action="update_contribution.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="contributionID" name="contributionID" value="<?php echo $contributionID; ?>">
                    <label for="title">Title:</label><br>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
                    <label for="content">Content:</label><br>
                    <textarea id="content" name="content" rows="4" cols="50"><?php echo $content; ?></textarea><br>
                    <label for="fileP">File Path:</label><br>
                    <input type="text" id="fileP" name="fileP" value="<?php echo $fileP; ?>"><br>
                    <label for="imgCv">CV Image:</label><br>
                    <input type="file" id="imgCv" name="imgCv"><br> <!-- Đổi input type thành file -->
                    <label for="imgSample">Sample Image:</label><br>
                    <input type="file" id="imgSample" name="imgSample"><br> <!-- Đổi input type thành file --><br>
                    <input type="submit" value="Update">
                </form>

                <script>
                    // JavaScript để chuyển hướng trở về trang trước đó sau khi submit form
                    document.getElementById("updateForm").addEventListener("submit", function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form

                        // Lưu trạng thái form trước khi submit
                        var formData = new FormData(this);

                        // Thực hiện submit form bằng Ajax
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", this.action);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Nếu cập nhật thành công, quay lại trang trước đó
                                window.history.back();
                            } else {
                                // Nếu có lỗi, xử lý tùy ý
                                console.error(xhr.responseText);
                            }
                        };
                        xhr.send(formData);
                    });
                </script>
            </body>
            </html>
            <?php
        } else {
            echo "Không tìm thấy thông tin đóng góp.";
        }
    } else {
        echo "Lỗi trong quá trình chuẩn bị câu lệnh SQL: " . $conn->error;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý dữ liệu từ form POST
    $contributionID = $_POST['contributionID'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $fileP = $_POST['fileP'];

    // Kiểm tra xem đã chọn file mới cho ảnh CV
    if ($_FILES['imgCv']['size'] > 0) {
        // Xử
    // Xử lý upload file mới cho ảnh CV
    $imgCv = $_FILES['imgCv']['name'];
    $imgCv_tmp = $_FILES['imgCv']['tmp_name'];
    move_uploaded_file($imgCv_tmp, "uploads/" . $imgCv);
} else {
    // Nếu không chọn file mới, giữ nguyên ảnh cũ
    $imgCv = $_POST['imgCv'];
}

// Kiểm tra xem đã chọn file mới cho ảnh mẫu
if ($_FILES['imgSample']['size'] > 0) {
    // Xử lý upload file mới cho ảnh mẫu
    $imgSample = $_FILES['imgSample']['name'];
    $imgSample_tmp = $_FILES['imgSample']['tmp_name'];
    move_uploaded_file($imgSample_tmp, "uploads/" . $imgSample);
} else {
    // Nếu không chọn file mới, giữ nguyên ảnh cũ
    $imgSample = $_POST['imgSample'];
}

// Cập nhật thông tin vào cơ sở dữ liệu
$sql_update = "UPDATE contributions 
                SET Title = ?, ContentP = ?, FileP = ?, ImgCv = ?, ImgSample = ?
                WHERE ContributionID = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("sssssi", $title, $content, $fileP, $imgCv, $imgSample, $contributionID);

if ($stmt_update->execute()) {
    echo "Cập nhật thông tin đóng góp thành công.";
} else {
    echo "Lỗi khi cập nhật thông tin đóng góp: " . $stmt_update->error;
}
} else {
    echo "Không có ID đóng góp được chọn.";
}

// Đóng kết nối
$conn->close();
?>
