<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Year Management</title>
    <link rel="stylesheet" href="./Css/cate.css"/>
    <style>
        /* Thêm CSS tại đây cho giao diện đẹp mắt */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .container1 {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 50px auto;
            max-width: 800px;
        }
        .container1 p {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        table tr:hover {
            background-color: #f9f9f9;
        }
        .button {
            background-color: #4caf50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #45a049;
        }
        .button span {
            vertical-align: middle;
        }
        .button_back {
            background-color: #f44336;
        }
        .button_back:hover {
            background-color: #d32f2f;
        }
        .button_back span {
            vertical-align: middle;
        }
        .edit_icon {
            color: green;
            text-decoration: none;
            font-size: 18px;
            margin-right: 5px;
        }
        .delete_icon {
            color: red;
            text-decoration: none;
            font-size: 18px;
            margin-left: 5px;
        }
    </style>
    <script>
        function deleteConfirm() {
            return confirm("Are you sure to delete?");
        }
    </script>
</head>
<body>
    <div class="container1">
        <p>ACADEMIC YEAR MANAGEMENT</p>
        <div>
            <a href="?page=addacayear" class="button"><span>ADD</span></a>
            <a href="?page=back" class="button button_back"><span>BACK &#10148;</span></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Academic year</th>
                    <th>Closure Date</th>
                    <th>Final Closure Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include_once("connection.php");
                    $result = mysqli_query($conn, "SELECT * FROM academicyear");
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                <tr>
                    <td><?php echo $row["YearID"]; ?></td>
                    <td><?php echo $row["AcaYear"]; ?></td>
                    <td><?php echo $row["closureDate"]; ?></td>
                    <td><?php echo $row["fclosureDate"]; ?></td>
                    <td>
                        <a href="?page=updateacayear&&id=<?php echo $row["YearID"]; ?>" class="edit_icon">&#9998;</a>
                    </td>
                    <td>
                    <a href="AcaYear.php?function=del&id=<?php echo $row["YearID"]; ?>" class="delete_icon" onclick="return deleteConfirm()">&#10006;</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
    include_once("connection.php");
    if(isset($_GET["function"]) && $_GET["function"] == "del"){
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            mysqli_query($conn, "DELETE FROM academicyear WHERE YearID='$id'");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=acayear"/>';
        }
    }
    
    ?>