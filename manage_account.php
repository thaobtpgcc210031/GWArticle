<style>
/* Reset some default styles */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container1 {
    margin: 20px auto;
    width: 80%;
}

p {
    font-size: 24px;
    font-weight: bold;
}

.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
}

.button:hover {
    background-color: #45a049;
}

table {
    border-collapse: collapse;
    width: 100%;
}

thead th {
    text-align: center;
    background-color: #4CAF50;
    color: white;
    padding: 8px;
}

tbody td {
    text-align: center;
    border-bottom: 1px solid #ddd;
    padding: 8px;
}

tbody tr:hover {
    background-color: #f2f2f2;
}

a {
    text-decoration: none;
    color: inherit;
}

a:hover {
    color: #4CAF50;
}

/* Style the update and delete icons */
.update-icon {
    color: green;
    text-decoration: none;
}

.delete-icon {
    color: red;
    text-decoration: none;
}

/* Style for confirm delete */
.confirm-delete {
    display: none;
}

/* Style for confirmation dialog */
.confirm-dialog {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.confirm-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.confirm-content p {
    margin: 0;
}

.confirm-content button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px;
    cursor: pointer;
    border-radius: 5px;
    border: none;
}

.confirm-content button:hover {
    background-color: #45a049;
}



</style>

<link rel="stylesheet" href="./Css/cate.css"/>
	<meta charset="utf-8" />
    <style>
  thead th {
    text-align: center; /* căn giữa nội dung của các thẻ th */
  }
</style>
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
            mysqli_query($conn, "DELETE FROM users WHERE UserID='$id'");
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=manage_account"/>';
        }
    }
    ?>
    <br>
<div class="container1">
    <p>ACCOUNT MANAGERMENT</p>
<div>
<a href="?page=add_account"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
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
    $result = mysqli_query($conn, "SELECT u.*, r.RoleName, d.departmentName FROM users u 
                                    JOIN roles r ON u.Role = r.RoleID 
                                    JOIN department d ON u.Depart = d.departmentID");
    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
?>
    <tr>
        <td style="text-align: center;"><?php echo $row["Username"];?></td>
        <td style="text-align: center;"><?php echo $row["fullName"];?></td>
        <td style="text-align: center;"><?php echo $row["Email"];?></td>
        <td style="text-align: center;"><?php echo $row["RoleName"];?></td>
        <td style="text-align: center;"><?php echo $row["departmentName"];?></td>
        <td style="text-align: center;"><?php echo $row["Address"];?></td>
        <td style="text-align: center;"><?php echo $row["Phone"];?></td>
        <td style='text-align:center'>
            <a href="?page=update_account&&id=<?php echo $row["UserID"]; ?>" style="color: green; text-decoration: none;">&#9998;</a>
        </td>
        <td style='text-align:center'>
            <a href="manage_account.php?function=del&&id=<?php echo $row["UserID"];?>" style="color: red; text-decoration: none;" onclick="return deleteConfirm()">&#10006;</a>
        </td>
    </tr>
<?php
    $No++;
    }
?>

			</tbody>    
</table>            


</div>
