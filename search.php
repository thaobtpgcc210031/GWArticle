<link rel="stylesheet" href="./Css/product.css">

    
    <div class="container-fluid">
        <div class="row justify-content-center" style="text-align: center; background-color:black">
            <a href="?page=show" class="col-2 cate-nav">All</a>
            <a href="?page=tshirt" class="col-2 cate-nav">Robot</a>
            <a href="?page=polo" class="col-2 cate-nav">Lego</a>
        </div>
         
    <div class="row"style="margin-top: 25px;">
     <H1>Searching for: "<?php echo $searching?>"</H1><hr>
    <?php
        include_once("connection.php");
        if(isset($_POST['search-btn'])){
            $searching = $_POST['searching'];
          }  
        $result = mysqli_query($conn, "SELECT * FROM `shirt` WHERE `ShiName` LIKE '%$searching%'" );

        if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
            }					            
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        ?>          
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 content-item">                       
            <a href="?page=detail_product&&id=<?php echo $row["ShiID"]; ?>" class="shirt-link">
            <div class="card-item"> 
            <img class="img-fluid" src="./Img/<?php echo $row['ShiImg']?>" alt="">
            </div>
            <div class="shirt-title">
            <?php echo $row['ShiName']?>
            </div>  
            <div class="shirt-price"style="font-weight: bold;">
            <?php echo $row['ShiPrice']?>.00&nbsp;USD
            </div>                
            </a>
            </div>  
        <?php
        }
        ?>
    </div>
    </div>
</div>
