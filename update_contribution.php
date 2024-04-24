<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-top: 0;
    font-size: 24px;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    color: #555;
}

input[type="text"],
textarea,
input[type="file"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("connection.php");

// Đảm bảo rằng thư mục "uploads" đã được tạo và tồn tại
$uploadsDir = "uploads/";
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0777, true);
}

// Kiểm tra xem có ID đóng góp được chọn không
if (isset($_GET['id'])) {
    $contributionID = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Xử lý dữ liệu từ form POST
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Xử lý file path
        $fileP = isset($_FILES['newFileP']['name']) ? $_FILES['newFileP']['name'] : $_POST['FileP'];
        if(isset($_FILES['newFileP']['tmp_name']) && !empty($_FILES['newFileP']['tmp_name'])) {
            // Kiểm tra phần mở rộng của tệp tin mới
            $newFileExtension = strtolower(pathinfo($_FILES['newFileP']['name'], PATHINFO_EXTENSION)); // Lấy phần mở rộng của tệp tin mới và chuyển thành chữ thường

            if ($newFileExtension !== 'docx') {
                echo "Chỉ được phép tải lên tệp có phần mở rộng là .docx";
                exit; // Dừng việc xử lý tiếp theo nếu phần mở rộng không phù hợp
            } else {
                // Tiếp tục xử lý tệp tin
                move_uploaded_file($_FILES['newFileP']['tmp_name'], $uploadsDir . $_FILES['newFileP']['name']);
            }
        } else {
            $fileP = $_POST['FileP'];
        }

        // Xử lý ảnh CV
        if ($_FILES['newImgCv']['size'] > 0) {
            $imgCv = $_FILES['newImgCv']['name'];
            $imgCv_tmp = $_FILES['newImgCv']['tmp_name'];
            move_uploaded_file($imgCv_tmp, $uploadsDir . $imgCv);
        } else {
            $imgCv = $_POST['imgCv'];
        }

        // Cập nhật thông tin vào cơ sở dữ liệu
        $sql_update = "UPDATE contributions 
                SET Title = ?, ContentP = ?, FileP = ?, ImgCv = ?
                WHERE ContributionID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssssi", $title, $content, $fileP, $imgCv, $contributionID);

        if ($stmt_update->execute()) {
            echo "Cập nhật thông tin đóng góp thành công.";
        } else {
            echo "Lỗi khi cập nhật thông tin đóng góp: " . $stmt_update->error;
        }
        
    }

    // Truy vấn để lấy thông tin của đóng góp dựa trên ContributionID
    $sql = "SELECT Title, ContentP, FileP, ImgCv FROM contributions WHERE ContributionID = ?";
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

            // Hiển thị form để chỉnh sửa thông tin
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Update Contribution</title>
                <style>
                    /* CSS styles */
                </style>
            </head>
            <body>
                <h2>Update Contribution</h2>
                <form id="updateForm" action="update_contribution.php?id=<?php echo $contributionID; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="contributionID" value="<?php echo $contributionID; ?>">
                    <label for="title">Title:</label><br>
                    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
                    <label for="content">Content:</label><br>
                    <textarea id="content" name="content" rows="4" cols="50"><?php echo $content; ?></textarea><br>
                    <label for="fileP">File Path:</label><br>
                    <input type="text" id="fileP" name="fileP" value="<?php echo $fileP; ?>"><br>
                    <input type="file" id="newFileP" name="newFileP"><br>
                    <label for="imgCv">CV Image:</label><br>
                    <input type="text" id="imgCv" name="imgCv" value="<?php echo $imgCv; ?>"><br>
                    <input type="file" id="newImgCv" name="newImgCv"><br>
                    
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
} else {
    echo "Không có ID đóng góp được chọn.";
}

// Đóng kết nối
$conn->close();
?>
