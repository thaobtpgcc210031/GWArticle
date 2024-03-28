<link rel="stylesheet" href="./Css/addform.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="css/addproductt.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>
<?php
include_once("connection.php");
function bind_Username($conn)
{
    $sqlstring = "SELECT UserID, Username FROM users";
    $result = mysqli_query($conn, $sqlstring);
    echo "<select name='users'>
            <option value ='0'>choose users</option>";
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<option value='" . $row['UserID'] . "'>" . $row['Username'] . "</option>";
    }
    echo "</select>";
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     uploaData();
// }
// function uploaData()
// {
    if (isset($_POST ["btnAdd"])) {
        // $email = $_POST['email'];
        $id =$_POST[''];
        $contri =$_POST['contribution'];
        $feedback = $_POST['feedback'];
        // $username =$_POST['users'];

        // echo '<div class="alert alert-warning alert-dismissible fade show" role" alert" <strong>Success!</strong> Feedback is submitted form '.$email. ' Thank You!! </div>'
        // ;
    }
    //submitting the database
    // $severname= "localhost";
    // $username ="root";
    // $password="";
    // include_once("connection.php");
    // if (!$conn) {
    //     echo '<div class="alert alert-warning alert-dismissible fade show" role" alert" <strong>Fail!</strong> </div>';
    // } 
    else {
        // $contri = htmlspecialchars(mysqli_real_escape_string($conn,$contri));
		// $feedback = htmlspecialchars(mysqli_real_escape_string($conn,$feedback));
		// $usernames = htmlspecialchars(mysqli_real_escape_string($conn,$username));
        
        if (mysqli_num_rows($result)==0) {
        
            $sqlstring ="INSERT INTO `comments` ( `ContributionID`, `Comment`, `CommentDate`, `UserID`) VALUES ( '$contri', '$feedback', current_timestamp(), '$users')";

            
            mysqli_query($conn,$sqlstring);
            echo '<meta http-equiv="refresh" content="0;URL=?page=feedback_manage"/>';
        } else {
            echo "<li>Duplicate Department ID or Name</li>";
        }
        
    }
// }
?>3



<div class="container1">
    <h1>Please enter Feedback</h1>
    <form action="index.php" method="post">

        
        <div class="mb-3">
            <label for="email" class="form-label">Username </label>
            <div class="col-sm-8">
                <?php bind_Username($conn); ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="contribution" class="form-label">Enter Your contribution</label>
            <textarea class="form-control" name="contribution" id="contribution" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="feedback" class="form-label">Enter Your Feedback</label>
            <textarea class="form-control" name="feedback" id="feedback" rows="3"></textarea>
        </div>

        <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
						      <input class="btnupdatePro" type="submit"  class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" style="font-size: 20px;margin-top: 5px;border-radius: 10px;margin-left: 50px;background: #F7E4E0;color: #C51162;font-family: fangsong; font-weight: bold;"/>
                              <input class="btnupdatePro" type="button" class="btn btn-primary" name="btnIgnore"  id="btnIgnore" value="Ignore" onclick="window.location='?page=feedback_manage	'" style="font-size: 20px;margin-top: 5px;border-radius: 10px;margin-left: 50px;background: #F7E4E0;color: #C51162;font-family: fangsong; font-weight: bold;"/>
                              	
						</div>
				</div>
    </form>
</div>