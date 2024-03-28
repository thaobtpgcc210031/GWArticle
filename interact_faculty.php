<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        /* Responsive layout */
        @media (max-width: 768px) {

            .left-panel,
            .right-panel {
                flex: 100%;
            }
        }

        /* Chat box styles */
        .chat-box {
            border: 1px solid #ccc;
            height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .chat-message .sender {
            font-weight: bold;
        }

        .chat-message .message-body {
            margin-left: 20px;
        }

        /* Download button styles */
        .download-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #45a049;
        }
        .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
    .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px; /* Adjust margin as needed */
}

    </style>
</head>
<?php
include_once("connection.php");

// Kiểm tra xem có ID đóng góp được chọn không
if (isset($_GET['id'])) {
    $contributionID = $_GET['id'];

    // Truy vấn để lấy thông tin của đóng góp dựa trên ContributionID
    $sql = "SELECT Title, ContentP, FileP, ImgCv, ImgSample, Status FROM contributions WHERE ContributionID = ?";
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
            $status = $row['Status'];

            // Thêm link PDF (điều chỉnh theo yêu cầu của bạn)
            $pdfLink = "download.php?file=example.pdf";
        }
    }
}
?>

<body>
    <form method="POST">
    <input type="hidden" id="selectedStatusInput" name="selectedStatus" value="<?php echo htmlspecialchars($status); ?>">
    <!-- Các phần còn lại của form -->
    <div class="container">
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
        <p><strong>Content:</strong> <?php echo $content; ?></p>
        <div class="dropdown">
            <?php if(empty($status)){?>
                <button class="dropbtn" id="selectedStatus" name="selectedStatus">Status</button>
                <div class="dropdown-content">
                    <a href="#" onclick="changeStatus('Approve')">Approve</a>
                    <a href="#" onclick="changeStatus('Reject')">Reject</a>
                </div>
            <?php }else{?>
                <button class="dropbtn" id="selectedStatus" name="selectedStatus"><?php echo $status; ?></button>
                <div class="dropdown-content">
                    <a href="#" value="1" onclick="changeStatus('Approve')">Approve</a>
                    <a href="#" value="2" onclick="changeStatus('Reject')">Reject</a>
                </div>
            <?php } ?>
        </div>
        <button type="submit" name="btnUpdateSta" id="btnUpdateSta" value="UpdateStatus">Update</button>
    </div>
        <div class="right-panel">
            <!-- Khung chat -->
            <h2>Chat</h2>
            <div class="chat-box">
                <!-- Tin nhắn chat sẽ được thêm bằng mã PHP -->
                <div class="chat-message">
                    <span class="sender">John:</span>
                    <span class="message-body">Hi there!</span>
                </div>
                <div class="chat-message">
                    <span class="sender">Jane:</span>
                    <span class="message-body">Hello!</span>
                </div>
                <!-- Tin nhắn sẽ tự động cuộn xuống dưới cùng -->
            </div>
            <!-- Form để gửi tin nhắn mới -->
            <form action="#" method="post">
                <input type="text" name="message" placeholder="Type here...">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
    </form>
</body>

<?php
  if(isset($_POST["btnUpdateSta"])){
	$status = $_POST["selectedStatus"];


    $err="";
    if(trim($contributionID)==""){
      $err .= "<li>Status update failed.1</li>";
      }else{
        $sq="Select * from contributions where ContributionID = '$contributionID'";
            $result= mysqli_query($conn, $sq);
            if(mysqli_num_rows($result)==1){
              $sqlstring="UPDATE contributions set Status='$status'
                     WHERE ContributionID='$contributionID'";
                    mysqli_query($conn, $sqlstring);
            echo '<script>window.location.href = "index.php?page=interact&id=' . $contributionID . '";</script>';
                    echo "Success";
            }else{
              echo "<li>Status update failed.2</li>";
            }
          }
      }
else{
  //echo '<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
}
?>

</html>
<script>
function changeStatus(status) {
    document.getElementById('selectedStatus').innerText = status;
    document.getElementById('selectedStatusInput').value = status;
}

</script>