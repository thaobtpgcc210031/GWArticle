<!DOCTYPE html>
<html lang="en">


<style>
    /* Reset CSS */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body */

    body {
        font-family: 'Nunito', sans-serif;
        background-color: #ffffff;
        /* Đổi nền thành trắng */
        color: #000000;
        /* Đổi màu chữ thành đen */
    }


    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Page Heading */
    .page-heading {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Button */
    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #333;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    /* Table */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #eea2ad;
        color: #000;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f2f2f2;
    }
</style>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="active">
        <?php
        include_once("connection.php");

        $currentYear = date("Y"); // Lấy năm hiện tại

        $sql = "SELECT u.Username AS userName, c.Title AS articleTitle, c.SubmissionDate AS submissionDate, c.FileP AS file
        FROM contributions c
        INNER JOIN users u ON u.UserID = c.UserID
        WHERE c.Status = 'Approve' AND YEAR(c.SubmissionDate) = $currentYear
        ORDER BY c.SubmissionDate DESC";

        $result = mysqli_query($conn, $sql);
        ?>

        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <!-- div content -->
    <div id="main">
        <div class="page-heading pb-2 mt-4 mb-2 ">
            <h3 style="text-align: center;">Contribution</h3>
        </div>

        <!-- 
      <div>
    <a class="btn btn-primary" href="../downloads/index.php" download>Download All Contributions</a>
</div> -->




        <div class="page-content">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <!-- <a href="" class="btn btn-success rounded-pill"> <?= $_SESSION["annualMagazineID"] ?></a> -->
            </div>
            <div class="container mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Student</th>
                            <th scope="col">Article Title</th>
                            <th scope="col">Upload Date</th>
                            <th scope="col">Action</th>



                        </tr>
                    </thead>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row['userName'] ?></td>
                            <td><?= $row['articleTitle'] ?></td>
                            <td><?= $row['submissionDate'] ?></td>
                            <td>
                                <a href='download.php?file=/<?php echo $row["file"] ?>' border='0' width="50" height="50">Download Article</a>
                            </td>


                        </tr>
                    <?php
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
            </div>
        </div>
    </div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        // Function to handle download when the button is clicked
        document.getElementById("downloadButton").addEventListener("click", function() {
            // Redirect to download.php
            window.location.href = "download.php";
        });
    </script>
</body>

</html>