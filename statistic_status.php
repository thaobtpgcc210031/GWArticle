<?php
// Khởi tạo mảng để lưu trữ tổng số lượng của mỗi status
$totalStatusCounts = array();

// Kiểm tra xem session role có tồn tại không, nếu không tồn tại, đưa người dùng về trang đăng nhập hoặc trang khác tùy thuộc vào yêu cầu của bạn
if (!isset($_SESSION['role'])) {
    header("Location: login.php"); // Điều hướng đến trang đăng nhập
    exit(); // Dừng thực thi mã PHP
}

include_once("connection.php");

// Lấy phòng ban của người dùng từ session
if ($_SESSION['role'] == 2) {
    $user_department = $_SESSION['depart']; 

    // Sử dụng truy vấn SQL để lấy tên phòng ban
    $department_query = "SELECT departmentName FROM department WHERE departmentID = $user_department";
    $department_result = $conn->query($department_query);
    $department_row = $department_result->fetch_assoc();
    $department_name = $department_row['departmentName'];

    $sql2 = "SELECT c.Status, COUNT(*) AS contribution_count
                FROM contributions c
                INNER JOIN users u ON c.UserID = u.UserID
                WHERE u.Depart = $user_department
                GROUP BY c.Status";
} else {
    // Trường hợp người dùng là Manager (role = 5), không cần phụ thuộc vào phòng ban
    $sql2 = "SELECT c.Status, COUNT(*) AS contribution_count
                FROM contributions c
                GROUP BY c.Status";
}

$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        // Lưu trữ tổng số lượng của mỗi status vào mảng
        $totalStatusCounts[$row2['Status']] = $row2['contribution_count'];
    }
}

$conn->close();
?>

<!-- Mã HTML của trang -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributor Statistics by Department</title>
    <!-- Thư viện Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load Google Charts
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'Status');
            data2.addColumn('number', 'Contribution Count');

            <?php
            // Loop qua mảng tổng số lượng của mỗi status để thêm vào biểu đồ
            foreach ($totalStatusCounts as $status => $count) {
                echo "data2.addRow(['" . $status . "', " . $count . "]);\n";
            }
            ?>

            var options2 = {
                title: '<?php echo ($_SESSION['role'] == 2) ? "Status in " . $department_name . " Faculty" : "Status in all Faculties"; ?>', // Sử dụng session để lấy phòng ban của người dùng
                pieSliceText: 'label',
                is3D: true,
                chartArea: {
                    left: 50,   
                    top: 50,
                    width: '90%',
                    height: '90%'
                }
            };
            var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
            chart2.draw(data2, options2);
        }
    </script>
</head>

<body>
    <div id="main" class="container1">
        <div class="page-content">
            <div class="container mb-3">
                <div class="row">
                    </div>
                    <div class="col-md-6">
                        <div id="piechart2" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
                <!-- Hiển thị tổng số lượng của mỗi status -->
                <div>
                    <?php
                    // Loop qua mảng tổng số lượng của mỗi status để hiển thị
                    foreach ($totalStatusCounts as $status => $count) {
                        echo $status . ": " . $count . "<br>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
