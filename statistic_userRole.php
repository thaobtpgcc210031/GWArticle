<?php
// Kết nối đến cơ sở dữ liệu
include_once("connection.php");
$current_page = basename($_SERVER['PHP_SELF']); // Lấy tên của trang hiện tại

// Kiểm tra xem trang hiện tại có phải là "manage_account.php" không
$is_manage_account_page = ($current_page === 'manage_account.php');

// Thực hiện truy vấn SQL để đếm số lượng người dùng cho mỗi vai trò và lấy tổng số lượng người dùng
$sql = "SELECT Role, COUNT(UserID) AS user_count FROM users GROUP BY Role";

$result = $conn->query($sql);

$data = array();
$data[] = ['Role', 'User Count'];

$totalUsers = 0; // Tổng số lượng người dùng

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Lưu kết quả của truy vấn vào biến $data để sử dụng trong biểu đồ
        $role = $row['Role'];
        $userCount = (int)$row['user_count'];
        // Chuyển vai trò từ số sang chuỗi để hiển thị
        switch ($role) {
            case 1:
                $roleName = "User";
                break;
            case 2:
                $roleName = "Guest";
                break;
            case 3:
                $roleName = "Coordinator";
                break;
            case 4:
                $roleName = "Admin";
                break;
            case 5:
                $roleName = "Marketing Manager";
                break;
            default:
                $roleName = "Unknown";
                break;
        }
        $data[] = [$roleName, $userCount];
        // Cập nhật tổng số lượng người dùng
        $totalUsers += $userCount;
    }
} else {
    // Nếu không có dữ liệu, thêm một dòng "No Data"
    $data[] = ['No Data', 0];
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Statistics by Role</title>
    <!-- Thư viện Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load Google Charts
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        // Hàm vẽ biểu đồ
        function drawChart() {
            var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

            var options = {
                title: 'Account Statistics by Role (Total Users: <?php echo $totalUsers; ?>)',
                pieSliceText: 'label',
                is3D: true,
                chartArea: {
                    left: 50,
                    top: 50,
                    width: '90%',
                    height: '90%'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div id="main">
        <div class="page-content">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-md-12">
                    <?php if ($role == 4): ?>
                    <a href="index.php"><button class="button" style="vertical-align:middle"><span>Home</span></button></a>
                    <a href="manage_account.php"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>
                    <?php endif; ?>
                        <!-- Địa điểm vẽ biểu đồ -->
                        <div id="piechart" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
