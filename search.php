<?php include_once("connection.php"); ?>
<link rel="stylesheet" href="./Css/product.css">  

<div class="container-fluid">
    <div class="row" style="margin-top: 25px;">
        <?php
        if(isset($_POST['search-btn'])){
            $searching = $_POST['searching'];
        ?>
            <h1>Searching for: "<?php echo $searching?>"</h1>
            <hr>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM `contributions` WHERE `title` LIKE '%$searching%'");
            if (!$result) {
                die('Invalid query: ' . mysqli_error($conn));
            }
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 content-item">
                    <a href="?page=detail_product&&id=<?php echo $row["ShiID"]; ?>" class="shirt-link">
                        <div class="card-item">
                            <img class="img-fluid" src="./Img/<?php echo $row['ShiImg'] ?>" alt="">
                        </div>
                        <div class="shirt-title">
                            <?php echo $row['ShiName'] ?>
                        </div>
                        <div class="shirt-price" style="font-weight: bold;">
                            <?php echo $row['ShiPrice'] ?>.00&nbsp;USD
                        </div>
                    </a>
                </div>
            <?php
            }
        } else {
            // Handle case where search button is not clicked
            echo "<h1>No search query found!</h1>";
        }
        ?>
    </div>
</div>
