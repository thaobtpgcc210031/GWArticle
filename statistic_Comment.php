<?php
// Kết nối đến cơ sở dữ liệu
include_once("connection.php");

// Khởi tạo biến để lưu trữ tổng số lượng Contribution
$totalContributions = 0;

// Xác định vai trò và department của người dùng
$userRole = $_SESSION['role'];
$userDepartment = $_SESSION['depart'];

// Lấy tên department từ cơ sở dữ liệu
$departmentQuery = "SELECT departmentName FROM department WHERE departmentID = $userDepartment";
$departmentResult = $conn->query($departmentQuery);

if ($departmentResult->num_rows > 0) {
    $departmentRow = $departmentResult->fetch_assoc();
    $departmentName = $departmentRow['departmentName'];
} else {
    // Nếu không tìm thấy tên phòng ban, gán một giá trị mặc định
    $departmentName = "Unknown Department";
}

// Thực hiện truy vấn SQL để lấy số lượng contribution đã và chưa có comment theo từng năm học và department của người dùng
if ($userRole == 2) {
    // Nếu là người dùng Guest
    $sql = "SELECT 
                IFNULL(SUM(CASE WHEN cm.CommentID IS NOT NULL THEN 1 ELSE 0 END), 0) AS commented_contributions,
                IFNULL(SUM(CASE WHEN cm.CommentID IS NULL THEN 1 ELSE 0 END), 0) AS not_commented_contributions,
                a.AcaYear
            FROM 
                academicyear a
                LEFT JOIN contributions co ON a.YearID = co.YearID
                LEFT JOIN comments cm ON co.ContributionID = cm.ContributionID
                INNER JOIN users u ON co.UserID = u.UserID
            WHERE 
                u.Depart = $userDepartment
            GROUP BY
                a.AcaYear";
    $totalContributionsMessage = "Total number of Contributions for all Academic Years according to $departmentName Faculty: ";
} elseif ($userRole == 5) {
    // Nếu là Manager
    $sql = "SELECT 
                 IFNULL(SUM(CASE WHEN cm.CommentID IS NOT NULL THEN 1 ELSE 0 END), 0) AS commented_contributions,
                 IFNULL(SUM(CASE WHEN cm.CommentID IS NULL THEN 1 ELSE 0 END), 0) AS not_commented_contributions,
                 a.AcaYear
            FROM 
                 academicyear a
                LEFT JOIN contributions co ON a.YearID = co.YearID
                LEFT JOIN comments cm ON co.ContributionID = cm.ContributionID
            GROUP BY
                 a.AcaYear";
    $totalContributionsMessage = "Total number of Contributions of all Faculties by Academic Year: ";
} else {
    // Người dùng không có quyền truy cập
    echo "Unauthorized access!";
    exit();
}

$result = $conn->query($sql);   
$data = array();
$data[] = ['Academic Year', 'Commented Contributions', 'Not Commented Contributions'];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row['AcaYear'], (int)$row['commented_contributions'], (int)$row['not_commented_contributions']];
        $totalContributions += (int)$row['commented_contributions'] + (int)$row['not_commented_contributions'];
    }
} else {
    // Nếu không có dữ liệu, thêm một dòng "No Data"
    $data[] = ['No Data', 0, 0];
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution Comment Statistics by Academic Year</title>
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
                title: 'Contribution Comment Statistics by Academic Year',
                isStacked: true,
                legend: { position: 'top', maxLines: 2 },
                vAxis: {title: 'Academic Year',  titleTextStyle: {color: '#333'}},
                hAxis: {title: 'Number of Contributions',  titleTextStyle: {color: '#333'}, minValue: 0}
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

            // Kiểm tra nếu dữ liệu chỉ có một bản ghi và là "No Data", thì hiển thị thông báo thích hợp
            if (data.getNumberOfRows() == 1 && data.getValue(0, 0) == 'No Data') {
            document.getElementById('chart-message').innerText = 'No Data available.';
        } else {
            chart.draw(data, options);
            // Hiển thị thông báo với nội dung phù hợp với vai trò của người dùng
            document.getElementById('total-contributions').innerText = '<?php echo $totalContributionsMessage . $totalContributions; ?>';
        }
    }
    </script>
</head>

<body>
    <div id="main">
        <div class="page-content">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Địa điểm vẽ biểu đồ -->
                        <div id="chart_div" style="width: 100%; height: 500px;"></div>
                        <div id="chart-message"></div>
                        <div id="total-contributions"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
