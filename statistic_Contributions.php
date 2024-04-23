<?php
// Kết nối đến cơ sở dữ liệu
include_once("connection.php");

// Khởi tạo biến options để lưu trữ các tùy chọn trong dropdown menu
$options = "";

// Thực hiện truy vấn SQL để lấy danh sách các năm học
$sql = "SELECT YearID, AcaYear FROM academicyear";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Duyệt qua kết quả từ truy vấn và tạo các tùy chọn
    while ($row = $result->fetch_assoc()) {
        $selected = "";
        if (isset($_POST['acaYear']) && $_POST['acaYear'] == $row['YearID']) {
            $selected = "selected";
        }
        $options .= "<option value='" . $row['YearID'] . "' $selected>" . $row['AcaYear'] . "</option>";
    }
} else {
    // Nếu không có dữ liệu, thông báo "No Data" và không cần hiển thị form
    echo "No Academic Year data available.";
    exit(); // Dừng thực thi mã HTML nếu không có dữ liệu
}

// Khởi tạo biến để lưu trữ tổng số lượng Contribution
$totalContribution = 0;

// Kiểm tra nếu đã submit form
if(isset($_POST['submit'])){
    $acaYearID = $_POST['acaYear'];

    if ($_SESSION['role'] == 2) {
        // Lấy department của người dùng đã đăng nhập từ session
        $user_department = $_SESSION['depart'];
        $department_query = "SELECT departmentName FROM department WHERE departmentID = $user_department";
        $department_result = $conn->query($department_query);
        $department_row = $department_result->fetch_assoc();
        $department_name = $department_row['departmentName'];

        // Thêm điều kiện WHERE vào truy vấn SQL để chỉ lấy dữ liệu của department của người dùng
        $sql = "SELECT d.departmentName, COUNT(c.ContributionID) AS contribution_count         
        FROM contributions c
        INNER JOIN users u ON c.UserID = u.UserID
        INNER JOIN department d ON u.Depart = d.departmentID
        INNER JOIN academicyear a ON c.YearID = a.YearID
        WHERE c.YearID = $acaYearID AND u.Depart = $user_department   
        GROUP BY d.departmentName";

    } else {
        // Trường hợp người dùng là Manager (role = 5)
        // Không cần lấy department từ session, chỉ thực hiện truy vấn SQL như bình thường
        $sql = "SELECT d.departmentName, COUNT(c.ContributionID) AS contribution_count         
        FROM contributions c
        INNER JOIN users u ON c.UserID = u.UserID
        INNER JOIN department d ON u.Depart = d.departmentID
        INNER JOIN academicyear a ON c.YearID = a.YearID
        WHERE c.YearID = $acaYearID   
        GROUP BY d.departmentName";

    }

    $result = $conn->query($sql);   
    $data = array();
    $data[] = ['Department', 'Contribution Count'];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [$row['departmentName'], (int)$row['contribution_count']];
            $totalContribution += (int)$row['contribution_count'];
        }
    } else {
        // Nếu không có dữ liệu, thêm một dòng "No Data"
        $data[] = ['No Data', 0];
    }
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution Statistics by Department</title>
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
                title: '<?php echo ($_SESSION['role'] == 2) ? "Number of Contributions at the Faculty of " . $department_name : "Number of contributions in all Faculties"; ?>',
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

            // Kiểm tra nếu dữ liệu chỉ có một bản ghi và là "No Data", thì hiển thị thông báo thích hợp
            if (data.getNumberOfRows() == 1 && data.getValue(0, 0) == 'No Data') {
                document.getElementById('chart-message').innerText = 'No Contribution data available.';
            } else {
                chart.draw(data, options);
                document.getElementById('total-contribution').innerText = 'Total Contribution: <?php echo $totalContribution; ?>';
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
                        <!-- Form để chọn năm học -->
                        <form method="post" action="">
                            <label for="acaYear">Select Academic Year:</label>
                            <select name="acaYear" id="acaYear">
                                <?php echo $options; ?>
                            </select>
                            <button type="submit" name="submit">Submit</button>
                        </form>
                        <div id="chart-message"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Địa điểm vẽ biểu đồ -->
                        <div id="piechart" style="width: 100%; height: 500px;"></div>
 
                        <div id="total-contribution"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
