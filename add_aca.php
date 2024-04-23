<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Academic Year</title>
  <link rel="stylesheet" href="./Css/addform.css">
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
      max-width: 600px;
    }

    h2 {
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    .row {
      margin-bottom: 20px;
    }

    .col-25 {
      width: 25%;
      float: left;
      text-align: right;
    }

    .col-75 {
      width: 75%;
      float: left;
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="date"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 15px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .btn_back {
      text-decoration: none;
      color: #333;
      padding: 10px 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .btn_back:hover {
      background-color: #f0f0f0;
    }

    .btn_back span {
      font-size: 16px;
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <div class="container1">
    <h2>Add Academic Year</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-25">
          <label for="aca">Academic Year</label>
        </div>
        <div class="col-75">
          <input type="text" id="aca" name="aca" placeholder="yyyy">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="clo">Closure Date</label>
        </div>
        <div class="col-75">
          <input type="date" id="clo" name="clo">
        </div>
      </div>
      <div class="row">
        <div class="col-25">
          <label for="fclo">Final Closure Date</label>
        </div>
        <div class="col-75">
          <input type="date" id="fclo" name="fclo">
        </div>
      </div>
      <div class="row">
        <input type="submit" name="btnAddAca" id="btnAddAca" value="ADD">
        <a href="?page=acayear" class="btn_back"><span>Back &#10148;</span></a>
      </div>
    </form>
  </div>
</body>

</html>
<?php
// Check if form is submitted
include_once("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
 

    // Process form data
    $acaYear = $_POST['aca'];
    $closureDate = $_POST['clo'];
    $fclosureDate = $_POST['fclo'];

    // Insert data into database
    $sql = "INSERT INTO academicyear (AcaYear, closureDate, fclosureDate) VALUES ('$acaYear', '$closureDate', '$fclosureDate')";
    
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
