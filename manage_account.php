<link rel="stylesheet" href="./Css/cate.css"/>
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
            mysqli_query($conn, "DELETE FROM magazine WHERE MagazineID='$id'");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=article"/>';
        }
    }
    ?>
    <br>
<div class="container1">
    <p>ACCOUNT MANAGERMENT</p>
<div>
<a href="?page=add_article"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
<a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

</div>
<table style="width:100%">
    <thead>
      <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Department</th>      
        <th>Address</th>
        <th>Phone</th>
      </tr>  
    </thead>  
    <tbody>
            <?php
                include_once("connection.php");
                $No=1;
                $result = mysqli_query($conn, "SELECT * FROM users");
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
            ?>
			<tr>

              <td style="text-align: center;"><?php echo $row["Username"];?></td>
              <td style="text-align: center;"><?php echo $row["fullName"];?></td>
              <td style="text-align: center;"><?php echo $row["Email"];?></td>
              <td style="text-align: center;"><?php echo $row["Role"];?></td>
              <td style="text-align: center;"><?php echo $row["Depart"];?></td>
              <td style="text-align: center;"><?php echo $row["Address"];?></td>
              <td style="text-align: center;"><?php echo $row["Phone"];?></td>
              <td style='text-align:center'>
              <a href="?page=update_account&&id=<?php echo $row["UserID"]; ?>" style="color: green; text-decoration: none;">
              &#9998;</a></td>
              <td style='text-align:center'>
              <a href="article.php?function=del&&id=<?php echo $row["UserID"];?>" style="color: red; text-decoration: none;" 
              onclick="return deleteConfirm()">&#10006;</a></td>
              
            </tr>
            <?php
                $No++;
                }
            ?>
			</tbody>    
</table>            


</div>
