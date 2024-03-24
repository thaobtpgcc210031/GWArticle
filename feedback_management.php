<!-- <link rel="stylesheet" href="./Css/cate.css"/>
	<meta charset="utf-8" />
    <script langguae="javascript">
        function deleteConfirm(){
            if(confirm("Are you sure to delete!")){
                return true;
            }else{
                return false;
            }
        }
    </script>
     <?php
    include_once("connection.php");
    if(isset($_GET["function"])=="del"){
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            mysqli_query($conn, "DELETE FROM comments WHERE CommentID='$id'");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=feedback_manage"/>';
        }
    }
    ?>
    <br>
<div class="container1">
    <p>FEEDBACK MANAGERMENT</p>
<div>
<a href="?page=create_feedback"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
<a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

</div>
<table style="width:100%">
    <thead>
      <tr>
        <th>Contribution ID</th>
        <th>UserName</th>
        <th>Comment</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>  
    </thead>  
    <tbody>
            <?php
                include_once("connection.php");
                $No=1;
                $result = mysqli_query($conn, "SELECT CommentID, ContributionID, Comment, Username
                                    FROM comments a, users b
                                    WHERE a.UserID = b.UserID
                                    ORDER BY CommentDate DESC
                
                ");
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
            ?>
			<tr>

              <td style="text-align: center;"><?php echo $row["CommentID"];?></td>
              <td style="text-align: center;"><?php echo $row["Username"];?></td>
              <td style="text-align: center;"><?php echo $row["Comment"];?></td>
              <td style='text-align:center'>
              <a href="?page=update_faculty&&id=<?php echo $row["CommentID"]; ?>" style="color: green; text-decoration: none;">
              &#9998;</a></td>
              <td style='text-align:center'>
              <a href="feedback_management.php?function=del&&id=<?php echo $row["CommentID"]; ?>" style="color: red; text-decoration: none;" 
              onclick="return deleteConfirm()">&#10006;</a></td>
              
            </tr>
            <?php
                $No++;
                }
                
            ?>
			</tbody>    
</table>
<h2></h2>


</div> -->
