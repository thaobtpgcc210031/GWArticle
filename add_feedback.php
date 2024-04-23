<link rel="stylesheet" href="./Css/addform.css">
<?php
// Bao gồm file kết nối
include_once("connection.php");
function bind_Contribution($conn)
{
  $sqlstring = "SELECT ContributionID, Title FROM contributions";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='contributionID'>
            <option value ='0'>Choose contributions</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['ContributionID'] . "'>" . $row['Title'] . "</option>";
  }
  echo "</select>";
}

function bind_User($conn)
{
  $sqlstring = "SELECT UserID, Username, fullName FROM users";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='userID'>
            <option value ='0'>Choose user (UserName-FullName)</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['UserID'] . "'>". $row['Username']. "-" . $row['fullName'] . "</option>";
  }
  echo "</select>";
}

if(isset($_POST['btnAddfback'])){	
	$contri = $_POST['contributionID'];
	$user = $_POST['userID'];
  $cmt = $_POST['comment'];
      mysqli_query($conn, "INSERT INTO comments(`ContributionID`, `Comment`, `CommentDate`, `UserID`) 
                          VALUES ('$contri','$cmt' , NOW(),'$user')") or die(mysqli_error($conn));
                          echo "Add feedback successfully";
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
  <div class="container1">
    <div>
  <h2>Add Feedback</h2>

  <form method="POST" enctype="multipart/form-data">

    <div class="row">
    <div class="col-25">
      <label for="fname">Contribution</label>
    </div>
    <div class="col-75">
      <?php bind_Contribution($conn); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Comment</label>
    </div>
    <div class="col-75">
    <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
    </div>
  </div>

    <div class="row">
    <div class="col-25">
      <label for="" class="col-25">User ID </label>
    </div>
      <div class="col-75">
        <?php bind_User($conn); ?>
      </div>
    </div>

    <br>
  <div class="row">
    <input type="submit" name="btnAddfback" id="btnAddfback" value="ADD">
    <a href="?page=manage_feedback" class="btn_back"><span>Back &#10148; </span></a>
  </div>
  </form>
  </div>
</div>

</body>

</html>
