<?php
include_once("connection.php");

// Lấy danh sách phản hồi từ bảng comments
$sql = "SELECT * FROM comments";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
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
    <h2>Feedback Management</h2>
    <div>
        <a href="?page=add_feedback"><button class="button" style="vertical-align:middle"><span>ADD</span></button></a>
        <a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148;</span></button></a>
    </div>
    <table>
        <tr>
            <th>Comment ID</th>
            <th>Contribution ID</th>
            <th>Comment</th>
            <th>Comment Date</th>
            <th>User ID</th>
            <th>Delete</th>
        </tr>
        <?php
            // Hiển thị dữ liệu từ bảng comments
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["CommentID"] . "</td>";
                    echo "<td>" . $row["ContributionID"] . "</td>";
                    echo "<td>" . $row["Comment"] . "</td>";
                    echo "<td>" . $row["CommentDate"] . "</td>";
                    echo "<td>" . $row["UserID"] . "</td>";
                    echo "<td><a href=\"manage_feedback.php?function=del&id=" . $row["CommentID"] . "\" style=\"color: red; text-decoration: none;\" onclick=\"return deleteConfirm()\">&#10006;</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No feedback found</td></tr>";
            }
            $conn->close();
        ?>
    </table>
</body>
</html>
