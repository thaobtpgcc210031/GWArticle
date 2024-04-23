<style>

/* Global styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container1 {
    width: 80%;
    margin: 0 auto;
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th, tbody td {
    text-align: center;
    padding: 8px;
    border-bottom: 1px solid #ddd;
}

thead th {
    background-color: #f2f2f2;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Delete button style */
.delete-btn {
    color: red;
    text-decoration: none;
}

.delete-btn:hover {
    text-decoration: underline;
}

</style>
<link rel="stylesheet" href="./Css/cate.css"/>
<style>
  thead th {
    text-align: center; /* căn giữa nội dung của các thẻ th */
  }
  tbody td{
    text-align: center;
  }
</style>
<?php
include_once("connection.php");

// Lấy danh sách phản hồi từ bảng comments
$sql = "SELECT comments.CommentID, contributions.Title, comments.Comment, comments.CommentDate, users.fullName 
        FROM comments 
        INNER JOIN users ON comments.UserID = users.UserID 
        INNER JOIN contributions ON comments.ContributionID = contributions.ContributionID";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Management</title>

    <script>
       function deleteConfirm() {
        return confirm("Are you sure you want to delete this feedback?");
    }

    <?php
    if(isset($_GET["function"]) && $_GET["function"]=="del"){
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            mysqli_query($conn, "DELETE FROM comments WHERE CommentID='$id'");
            echo 'window.location.href = "index.php?page=manage_feedback";'; // Thay đổi cách chuyển hướng trang
        }
    }
    ?>
    </script>
</head>
<body>
<br>
<div class="container1">
    <p>FEEDBACK MANAGERMENT</p>
<div>
<a href="?page=add_feedback"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
<a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

</div>
<table style="width:100%">
    <thead>
    <tr>
            <th>Comment ID</th>
            <th>Contribution</th>
            <th>Comment</th>
            <th>Comment Date</th>
            <th>User</th>
            <th>Delete</th>
        </tr>
    </thead>  
    <tbody>
    <?php
            // Hiển thị dữ liệu từ bảng comments
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["CommentID"] . "</td>";
                    echo "<td>" . $row["Title"] . "</td>";
                    echo "<td>" . $row["Comment"] . "</td>";
                    echo "<td>" . $row["CommentDate"] . "</td>";
                    echo "<td>" . $row["fullName"] . "</td>";
                    echo "<td><a href=\"manage_feedback.php?function=del&id=" . $row["CommentID"] . "\" style=\"color: red; text-decoration: none;\" onclick=\"return deleteConfirm()\">&#10006;</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No feedback found</td></tr>";
            }
            $conn->close();
        ?>

			</tbody>    
</table>            

    
</body>
</html>
