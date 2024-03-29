<?php
// Bao gồm file kết nối
include_once("connection.php");
function bind_Contribution($conn)
{
  $sqlstring = "SELECT ContributionID, Title FROM contributions";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='contributionID'>
            <option value ='0'>choose contributions</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['ContributionID'] . "'>" . $row['Title'] . "</option>";
  }
  echo "</select>";
}

function bind_User($conn)
{
  $sqlstring = "SELECT UserID FROM users";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='userID'>
            <option value ='0'>choose user</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['UserID'] . "'>" . $row['UserID'] . "</option>";
  }
  echo "</select>";
}



// Xử lý dữ liệu khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Kiểm tra và lấy dữ liệu từ form
  $contributionID = $_POST["contributionID"];
  $comment = $_POST["comment"];
  $userID = $_POST["userID"];

  // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng comments
  $sql = "INSERT INTO comments (ContributionID, Comment, UserID) VALUES ('$contributionID', '$comment', '$userID')";

  // Thực thi câu lệnh SQL
  if (mysqli_query($conn, $sql)) {
    // Chuyển hướng người dùng sau khi thêm thành công
    header("Location: manage_feedback.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Feedback</title>
</head>

<body>
  <h2>Add Feedback</h2>

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row">
      <label for="" class="col-25">Contribution </label>
      <div class="col-75">
        <?php bind_Contribution($conn); ?>
      </div>
    </div>

    <label for="comment">Comment:</label><br>
    <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>

    <div class="row">
      <label for="" class="col-25">User ID </label>
      <div class="col-75">
        <?php bind_User($conn); ?>
      </div>
    </div>

    <input type="submit" value="Submit">
  </form>
</body>

</html>
