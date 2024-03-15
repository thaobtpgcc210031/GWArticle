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
            mysqli_query($conn, "DELETE FROM category WHERE Cat_ID='$id'");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=feedback"/>';
        }
    }
    ?>
    <br>
<div class="container1">
    <p>ARTICLE MANAGERMENT</p>
<div>
<a href="?page=add_feedback"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
<a href="?page=home"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

</div>
<table style="width:100%">
    <thead>
      <tr>
        <th>No.</th>
        <th>ID</th>
        <th>Name</th>
        <th>Feedback</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>  
    </thead>  
    <tbody>
            <?php
                include_once("connection.php");
                $No=1;
                $result = mysqli_query($conn, "SELECT * FROM category");
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
            ?>
			<tr>
              <td class="cotCheckBox" style="text-align: center;"><?php echo $No; ?></td>
              <td style="text-align: center;"><?php echo $row["Cat_ID"];?></td>
              <td style="text-align: center;"><?php echo $row["Cat_Name"];?></td>
              <td style="text-align: center;"><?php echo $row["Cat_Des"];?></td>
              <td style='text-align:center'>
              <a href="?page=update_feedback&&id=<?php echo $row["Cat_ID"]; ?>" style="color: green; text-decoration: none;">
              &#9998;</a></td>
              <td style='text-align:center'>
              <a href="feedback.php?function=del&&id=<?php echo $row["Cat_ID"]; ?>" style="color: red; text-decoration: none;" 
              onclick="return deleteConfirm()">&#10006;</a></td>
              
            </tr>
            <?php
                $No++;
                }
                
            ?>
			</tbody>    
</table>
<h2></h2>


</div>
