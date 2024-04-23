
<style>
    .container {
    width: 80%;
    margin: 0 auto;
}

.btn-primary {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.table th {
    background-color: #eea2ad;
    color: #000;}

.table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #ddd;
}
    
</style>
<div class="container">
       
        <!-- <div>
            <a href="../atn/Download/index.php" class="btn btn-primary">Download All Contributions</a>
        </div> -->

     

<?php

include_once("connection.php");

// Check if the AcaYear parameter is provided in the URL
if(isset($_GET['AcaYear'])){
    // Get the AcaYear from the URL
    $acaYear = $_GET['AcaYear'];

    // Query to retrieve contribution details based on AcaYear and only display approved contributions
    $sql = "SELECT A.AcaYear, C.UserID, C.Title, C.SubmissionDate
            FROM academicyear AS A
            INNER JOIN contributions AS C ON A.YearID = C.YearID
            WHERE A.AcaYear = '$acaYear' AND C.Status = 'Approve'";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error executing the query: " . mysqli_error($conn));
    }

    // Display the result
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='container'>
                <h1>Contribution Detail</h1>
                <table class='table'>
                    <thead>
                        <tr>
                            <th>Aca Year</th>
                            <th>User ID</th>
                            <th>Title</th>
                            <th>Submit Date</th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['AcaYear']}</td>
                    <td>{$row['UserID']}</td>
                    <td>{$row['Title']}</td>
                    <td>{$row['SubmissionDate']}</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    } else {
        echo "No contributions found for the specified AcaYear that have been approved.";
    }

    // Free up memory after using the query result
    mysqli_free_result($result);
} else {
    echo "AcaYear parameter is missing in the URL.";
}

// Close the database connection
mysqli_close($conn);
?>
 <script type="text/javascript">
            // Function to handle download when the button is clicked
            document.getElementById("downloadButton").addEventListener("click", function() {
                // Redirect to download.php
                window.location.href = "download.php";
            });
        </script>
        </body>

</html>