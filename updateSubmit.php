<?php
include_once("connection.php");

if(isset($_POST['submit'])) {
    $contributionID = $_POST['contributionID'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Cập nhật các trường thông tin
    $query = "UPDATE contributions SET Title='$title', ContentP='$content' WHERE ContributionID='$contributionID'";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        // Cập nhật các trường hình ảnh nếu có
        if(isset($_FILES['fileP']['name']) && !empty($_FILES['fileP']['name'])) {
            $fileP_name = $_FILES['fileP']['name'];
            $fileP_tmp = $_FILES['fileP']['tmp_name'];
            $fileP_size = $_FILES['fileP']['size'];
            $fileP_type = $_FILES['fileP']['type'];
        
            // Kiểm tra loại file
            $allowed_types = array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            if (!in_array($fileP_type, $allowed_types)) {
                echo "Only .doc and .docx files are allowed for FileP.";
                exit;
            }
        
            // Di chuyển và cập nhật tên file
            move_uploaded_file($fileP_tmp, "uploads/" . $fileP_name);
            mysqli_query($conn, "UPDATE contributions SET FileP='uploads/$fileP_name' WHERE ContributionID='$contributionID'");
        }
        if(isset($_FILES['imgCv']['name']) && !empty($_FILES['imgCv']['name'])) {
            $imgCv = $_FILES['imgCv']['name'];
            move_uploaded_file($_FILES['imgCv']['tmp_name'], "uploads/" . $imgCv);
            mysqli_query($conn, "UPDATE contributions SET ImgCv='uploads/$imgCv' WHERE ContributionID='$contributionID'");
        }
        
        
        echo "Contribution updated successfully.";
        echo '<meta http-equiv="refresh" content="2;URL=index.php?page=submit"/>';
        exit;
    } else {
        echo "Error updating contribution: " . mysqli_error($conn);
    }
}

// Lấy ID bài viết từ tham số truyền vào
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Truy vấn để lấy thông tin bài viết
    $query = "SELECT * FROM contributions WHERE ContributionID='$id'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['Title'];
        $content = $row['ContentP'];
    } else {
        echo "Contribution not found.";
        exit;
    }
} else {
    echo "No contribution ID provided.";
    exit;
}
?>

<form method="POST" action="" enctype="multipart/form-data"><input type="hidden" name="contributionID" value="<?php echo $id; ?>">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" value="<?php echo $title; ?>"><br>
    <label for="content">Content:</label><br>
    <textarea id="content" name="content"><?php echo $content; ?></textarea><br><br>
    <label for="fileP">FileP:</label><br>
    <input type="file" id="fileP" name="fileP"><br>
    <label for="imgCv">Image CV:</label><br>
    <input type="file" id="imgCv" name="imgCv"><br>
    
    <input type="submit" name="submit" value="Update Contribution">
</form>