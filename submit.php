<link rel="stylesheet" href="./Css/cate.css" />
<meta charset="utf-8" />
<style>
    /* Add these styles to your cate.css file */
    .status-approve {
        color: green;
        /* Màu chữ xanh cho trạng thái approved */
        font-weight: bold;
        /* In đậm chữ */
    }

    .status-reject {
        color: red;
        /* Màu chữ đỏ cho trạng thái rejected */
        font-weight: bold;
        /* In đậm chữ */
    }

    .status-default {
        color: inherit;
        /* Màu chữ mặc định */
        font-weight: normal;
        /* Không in đậm chữ */
    }
    .button-dl {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff5722; /* Màu cam */
    color: white;
    text-decoration: none;
    border-radius: 5px;
    border: 1px solid #ff5722; /* Viền màu cam */
    float: right; /* Nút sẽ nằm bên phải */
    transition: background-color 0.3s, color 0.3s;
}

.button-dl:hover {
    background-color: #ff7043; /* Màu cam nhạt */
}

</style>
<script language="javascript">
    function deleteConfirm() {
        if (confirm("Are you sure to delete!")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php
include_once("connection.php");
if (isset($_GET["function"]) && $_GET["function"] == "del") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        mysqli_query($conn, "DELETE FROM contributions WHERE ContributionID='$id'");
        echo '<meta http-equiv="refresh" content="0;URL=index.php?page=contribution"/>';
    }
}
?>
<br>
<div class="container1">
    <?php
    if (isset($_SESSION['role']) && $_SESSION['role'] == 3) {
    ?>
        <p>CONTRIBUTION MANAGEMENT OF <?php $de = $_SESSION["depart"];
        $depa = mysqli_query($conn,"SELECT departmentName FROM department WHERE departmentID = $de");
        
        $row = mysqli_fetch_array($depa, MYSQLI_ASSOC);
        echo $row["departmentName"];?></p>
        <div>
            <a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

        </div>
        <table style="width:100%">
            <thead>
                <tr>
                    <th> ID </th>
                    <th>UserName</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>SubmitDate</th>
                    <th>AcademicYear</th>
                    <th>Closure</th>
                    <th>F.Closure</th>
                    <th>File</th>
                    <th>Download</th>
                    <th>Image</th>
                    <th>Detail</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $No = 1;
                
                $result = mysqli_query($conn, "SELECT contributions.*, users.Username, department.departmentName, academicyear.AcaYear, academicyear.closureDate, academicyear.fclosureDate
FROM contributions INNER JOIN users ON contributions.UserID = users.UserID INNER JOIN department ON users.Depart = department.departmentID
                INNER JOIN academicyear ON contributions.YearID = academicyear.YearID Where departmentID = $de");
                
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $row["ContributionID"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["Username"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["Title"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["ContentP"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["SubmissionDate"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["AcaYear"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["closureDate"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["fclosureDate"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["FileP"]; ?></td>

                        <td>
                                <a href='download.php?file=/<?php echo $row["FileP"] ?>' border='0' width="50" height="50">Download Article</a>
                            </td>
                        <td style="text-align: center;"><img style="width:100px; height:100px" src="./Img/<?php echo $row["ImgCv"]; ?>" alt="Image"></td>
                        <td style='text-align:center'>
                            <a href="?page=interact&&id=<?php echo $row["ContributionID"]; ?>" style="color: green; text-decoration: none;">
                                &#9998;</a>
                        </td>
                        <td style="text-align: center;">
                            <span class="<?php echo strtolower($row["Status"]) === 'approve' ? 'status-approve' : (strtolower($row["Status"]) === 'reject' ? 'status-reject' : 'status-default'); ?>">
                                <?php echo $row["Status"]; ?>
                            </span>
                        </td>
                    </tr>
                <?php
                    $No++;
                }
                ?>
                <script type="text/javascript">
                        // Function to handle download when the button is clicked
                        document.getElementById("downloadButton").addEventListener("click", function() {
                            // Redirect to download.php
                            window.location.href = "download.php";
                        });
                    </script>
            </tbody>
        </table>
        <h2></h2>
    <?php
    } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 5) {
    ?>
        <p>APPROVED CONTRIBUTION</p>
        <div>
<a class="button-dl" href="<?php echo $pdfLink; ?>" download>Download all ZIP</a>
            <a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>
        </div>
        <table style="width:100%">
            <thead>
                <tr>
                    <th> ID </th>
                    <th>UserName</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Submission Date</th>
                    <th>FileP</th>
                    <th>Department Name</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $No = 1;
                $result = mysqli_query($conn, "SELECT contributions.*, users.Username, department.departmentName FROM contributions INNER JOIN users ON contributions.UserID = users.UserID INNER JOIN department ON users.departmentID = department.departmentID");
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $status = empty($row["Status"]) ? "Considering" : $row["Status"];
                ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $row["ContributionID"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["Username"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["Title"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["ContentP"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["SubmissionDate"]; ?></td>
                        <td style="text-align: center;"><?php echo $row["FileP"]; ?></td>
                        <td style="text-align: center;"><img style="width:100px; height:100px" src="./Img/<?php echo $row["ImgCv"]; ?>" alt="Image"></td>
                        <td style="text-align: center;"><?php echo $row["departmentName"]; ?></td>
                        <td style='text-align:center'>
                            <a href="?page=interact&&id=<?php echo $row["ContributionID"]; ?>" style="color: green; text-decoration: none;">
                                &#9998;</a>
                        </td>
                    </tr>
                <?php
                    $No++;
                }
                ?>
                
            </tbody>
        </table>
        <h2></h2>
    <?php
    }
    ?>
</div>
<script type="text/javascript">
        // Function to handle download when the button is clicked
        document.getElementById("downloadButton").addEventListener("click", function() {
            // Redirect to download.php
            window.location.href = "download.php";
        });
    </script>