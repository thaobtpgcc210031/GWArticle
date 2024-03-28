<link rel="stylesheet" href="./Css/cate.css" />
<meta charset="utf-8" />
<script language="javascript">
    function deleteConfirm() {
        if (confirm("Are you sure to delete!")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?php
include_once("connection.php");
if (isset($_GET["function"]) && $_GET["function"] == "del") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        mysqli_query($conn, "DELETE FROM contributions WHERE ContributionID='$id'");
        echo '<meta http-equiv="refresh" content="0;URL=index.php?page=contribution"/>';
    }
}
?>
<br>
<div class="container1">
    <p>CONTRIBUTION MANAGERMENT</p>
    <div>
        <a href="?page=add_contribution"><button class="button" style="vertical-align:middle"><span>ADD </span></button></a>
        <a href="?page=back"><button class="button" style="vertical-align:middle"><span>BACK &#10148; </span></button></a>

    </div>
    <table style="width:100%">
        <thead>
            <tr>
            <th> ID </th>
                <th>User ID</th>
                <th>Title</th>
                <!-- <th>Public Date</th> -->
                <th>Content</th>
                <th>SubmissionDate</th>
                <th>FileP</th>
                <th>Image CV</th>
                <th>Image Sample</th>
                <th>Detail</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include_once("connection.php");
            $No = 1;
            $result = mysqli_query($conn, "SELECT * FROM contributions");
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
                <tr>
                <td style="text-align: center;"><?php echo $row["ContributionID"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["StudentID"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["Title"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["ContentP"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["SubmissionDate"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["FileP"]; ?></td>
    <?php 
    // Kiểm tra xem trường ImgSample có giá trị không
    if (!empty($row["ImgSample"])) {
        // Nếu có, hiển thị hình ảnh
        echo "<img src='".$row["ImgSample"]."' alt=''>";
    } else {
        // Nếu không, hiển thị thông báo hoặc ảnh mặc định
        echo "No image available";
    }
    ?>
</td>
                    <td style="text-align: center;"><?php echo $row["ImgCv"]; ?></td>
                    <td style="text-align: center;"><?php echo $row["ImgSample"]; ?></td>
                    
                    <td style='text-align:center'>
                        <a href="?page=interact&&id=<?php echo $row["ContributionID"]; ?>" style="color: green; text-decoration: none;">
                            &#9998;</a>
                    </td>
                    <td style='text-align:center'>
                        <a href="submit.php?function=del&&id=<?php echo $row["ContributionID"]; ?>" style="color: red; text-decoration: none;" onclick="return deleteConfirm()">&#10006;</a>
                    </td>

                </tr>
            <?php
                $No++;
            }

            ?>
        </tbody>
    </table>
    <h2></h2>


</div>