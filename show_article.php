<link rel="stylesheet" href="./Css/product.css">

    
    <div class="container-fluid">

         
    <div class="row"style="margin-top: 25px;">
     <H1>All Off Shirts</H1><hr>
    <?php
        include_once("connection.php");
        $result = mysqli_query($conn, "SELECT * FROM shirt" );

        if (!$result) {
            die('Invalid query: ' . mysqli_error($conn));
            }					            
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        ?>          
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 content-item">                       
            <a href="?page=detail_article&&id=<?php echo $row["ShiID"]; ?>" class="shirt-link">
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

