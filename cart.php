<style>
    th{
        text-align: center;
    }
    h2{
        text-align: center;
        padding: 10px 0;
    }
    .tbCart{
        border-top: 20px solid  #F8F8F0;
        width: 100%;
        background-color: #F8F8F0;
    }
    .btnPay{
        width: 200px;
        height: 40px;
        border-radius: 0;
        border: 0;
        background-color: #7ED36B;
        font-weight: bold;
    }
    .btnPay:hover{
        background-color: #86E072;
    }

</style>


<h2>Your Cart</h2>
<?php
$sql = "SELECT SUM(total_Price) from theCart where Username = '" .$_SESSION["us"]. "'";
$q = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($q);

if($row[0] ==""){
    echo '<p style="font-weight:bold;">Your cart is EMPTY</p>'; 
}else{
?>
<table class="tbCart">
    <thead >
      <tr>
        <th >No.</th>
        <th>Shirt Name</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Time</th>
        <th>Picture</th>
      </tr>  
    </thead> 
    <tbody>
        <?php
            include_once("connection.php");
            $No=1;
            $result = mysqli_query($conn, "SELECT * FROM theCart where Username = 
            '" .$_SESSION["us"]. "'");
            while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
        ?>
        <tr>
            <td class="cotCheckBox" style="text-align: center;"><?php echo $No; ?></td>
            <td style="text-align: center;"><?php echo $row["pro_Name"];?></td>
            <td style="text-align: center;"><?php echo $row["cart_Qty"];?></td>
            <td style="text-align: center;"><?php echo $row["total_Price"];?> .00$</td>
            <td style="text-align: center;"><?php echo $row["date"];?></td>
            <td style="text-align: center;"><img src="./Img/<?php echo $row['cart_Img']?>" border='0' width="100" height="100" alt=""></td>
        </tr>
        <?php
                $No++;
                }
                
            ?>
    </tbody>
    
</table>

<hr>
<p>Total price: <?php
$sql = "SELECT SUM(total_Price) from theCart where Username = '" .$_SESSION["us"]. "'";
$q = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($q);
    echo  $row[0];
 ?>.00$</p>
<div class="form1">
        <input type="submit" class="btnPay" value="Payment">
</div><?php }?>