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
            mysqli_query($conn, "DELETE FROM shirt WHERE ShiID='$id'");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=article"/>';
        }
    }
    ?>
    <br>
<div class="container1">
    <p>ARTICLE MANAGERMENT</p>
<div>
<a href="?page=add_article"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
<a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

</div>
<table style="width:100%">
    <thead>
      <tr>
        <th>ID</th>
        <th>Contribution</th>
        <th>Academic Year</th>
        <th>Public Date</th>
        <th>Content</th>
        <th>Closure Date</th>
        <th>Final Closure Date</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>  
    </thead>  
    <tbody>
            <?php
                include_once("connection.php");
                $No=1;
                $result = mysqli_query($conn, "SELECT * FROM magazine");
                while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
            ?>
			<tr>

              <td style="text-align: center;"><?php echo $row["MagazineID"];?></td>
              <td style="text-align: center;"><?php echo $row["ContributionID"];?></td>
              <td style="text-align: center;"><?php echo $row["AcaYear"];?></td>
              <td style="text-align: center;"><?php echo $row["PublicationDate"];?></td>
              <td style="text-align: center;"><?php echo $row["ContentM"];?></td>
              <td style="text-align: center;"><?php echo $row["ClosureDate"];?></td>
              <td style="text-align: center;"><?php echo $row["FinalClosureDate"];?></td>
              <td style='text-align:center'>
              <a href="?page=update_article&&id=<?php echo $row["MagazineID"]; ?>" style="color: green; text-decoration: none;">
              &#9998;</a></td>
              <td style='text-align:center'>
              <a href="article.php?function=del&&id=<?php echo $row["MagazineID"]; ?>" style="color: red; text-decoration: none;" 
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
