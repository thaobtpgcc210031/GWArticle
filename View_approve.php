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
        background-color: #f8f9fa;
        color: #333;
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
        $sql = "SELECT * FROM academicyear ORDER BY fclosureDate DESC";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Error executing the query: " . mysqli_error($conn));
        }
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
            <h2 style="text-align: center; font-weight:bold">Annual Contribution</h2>
        </div>

        <div class="page-content">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
            </div>
            <div class="container mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Aca Year</th>
                            <th scope="col">Closure Date</th>
                            <th scope="col">Final Closure Date</th>
                            <th scope="col">Action</th>
                            <th scope="col">Download</th>
                        </tr>
                    </thead>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row['AcaYear'] ?></td>
                            <td><?= $row['closureDate'] ?></td>
                            <td><?= $row['fclosureDate'] ?></td>
                            <td>
                                <a href="?page=detailM&&AcaYear=<?php echo $row["AcaYear"]; ?>" class="btn btn-warning rounded-pill"> More Details </a>
                            </td>
                            <td> <a href="downloadZIP.php?YearID=<?= $row["YearID"]; ?>" class="btn btn-warning rounded-pill">Download</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
