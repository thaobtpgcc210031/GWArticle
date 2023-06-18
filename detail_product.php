<link rel="stylesheet" href="./Css/detail_product.css">
<?php
include_once("connection.php");
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $result = mysqli_query($conn, "SELECT * FROM shirt WHERE ShiID = '$id'");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $price = $row['ShiPrice'];
    $name = $row['ShiName'];
    $image = $row['ShiImg'];
    //echo $_SESSION['us'];
}


    if(isset($_POST['btnAddCart'])){
        $qty=$_POST['txtAmount'];
        $usrname = $_SESSION['us'];
        $sz = $_POST['size'];
        if($sz != "size"){
            if($qty !=""){
            $total = $price * $qty;
            $sz = $_POST['size'];
            mysqli_query($conn, "INSERT INTO theCart (pro_Name, size, cart_Qty, date, userName ,total_Price, cart_Img)
                                VALUES ('$name','$sz' ,'$qty','".date('Y-m-d H:i:s')."','$usrname','$total','$image')") or die(mysqli_error($conn));
            echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';
                
            }else{
                echo'<li>enter quantity</li>';
            }
            
        }else{
           echo '<li>choose size</li>'; 
            
        }

        
    }


?>
<div class="container-fluid">
    <form action="" method="POST">
        <div class=" row justify-content-md-center">
        <div class="col-lg-3  col-sm-12  left-detail" >
            <div class="left-img"><img src="./Img/<?php echo $image ?>" class="img-fluid" ></div>
        </div>
        <div class="col-lg col-sm-12 ml-sm-auto right-detail">
            <div class="right-info">
                <div class="title"><?php echo $name;?></div>
                <div class="price"><?php echo $price;?>.00 $</div>
                <select name="size" id="size" class="size">
                    <option value="size">Size</option>
                    <option value="Small">Small</option>
                    <option value="Big">Big</option>
                </select>
                <div class="amount">
                    <p style="margin-bottom: 0; font-size:25px;">Amount</p>
                    <input type="text" class="input-amount" id="txtAmount" name="txtAmount"></div>
                
                    <input type="submit" style="padding-top: 0; margin-top: 10px;" id="btnAddCart" name="btnAddCart" class="add-cart" value="Add To Cart">
                
            </div>
        </div>
        </div>
    </form>
    


</div>


