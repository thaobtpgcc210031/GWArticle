<link rel="stylesheet" href="./OwlCarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="./OwlCarousel/dist/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="./Css/contentstyle.css">
<link rel="stylesheet" href="./Css/contentmiddle.css">
<style>
  
    @import url('https://fonts.googleapis.com/css2?family=Satisfy&family=Space+Mono&display=swap');  .more-link{
    padding: 5px;
    font-weight: bold;
    font-size: large;    
  }
  .more-link:hover{
    text-shadow: 1px 1px 2px white, 0 0 1em grey, 0 0 0.2em grey;
  }
  .bttm-content{
    font-family: 'Space Mono', monospace;
    color: #e6e6e6;
    padding-top: 200px;
    width: 100%;
    height: 100%;
    text-align: center;
    font-style: italic;
    position: absolute;
  }
  .fa {
    padding: 25px;
    font-size: 30px;
    width: 85px;
    text-align: center;
    text-decoration: none;
    color: white;
  }
  .fa:hover {
    background-color: #e6e6e6;
    color: black;
    border-radius: 75px;
  }
  
</style>


<section>
    <div class="owl-carousel owl-theme">
        <div class="slide-item slItem_1"><img class="sl_img" src="./Img/slide1.jpg" alt=""></div>
        <div class="slide-item slItem_2"><img class="sl_img" src="./Img/slide2.jpg" alt=""></div>
        <div class="slide-item slItem_3"><img class="sl_img" src="./Img/slide3.jpg" alt=""></div>
        <div class="slide-item slItem_4"><img class="sl_img" src="./Img/slide4.jpg" alt=""></div>
    </div>
</section>


<div class="container-content-item">
        <h2 style="text-align: center;padding-top:50px; padding-bottom: 20px;">// Best Sellers //</h2>
        <div class="container-fluid">
        <div class="row"> 
        <?php

		  	$result = mysqli_query($conn, "SELECT * FROM shirt where SoldQty > 10" );
			
			if (!$result) {
                die('Invalid query: ' . mysqli_error($conn));
                }					            
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			?>          
          <div class="col-lg-3 	col-md-4 col-sm-6 col-12 content-item">                       
            <a href="?page=detail_product&&id=<?php echo $row["ShiID"]; ?>" class="shirt-link">
                <div class="card-item"> 
                <img class="img-fluid" src="./Img/<?php echo $row['ShiImg'];?>" alt="">
                </div>
                <div class="shirt-title">
                <?php echo $row['ShiName'];?>
                </div>  
                <div class="shirt-price" style="font-weight: bold;">
                <?php echo $row['ShiPrice'];?>.00&nbsp;USD
                </div>

            </a>
        </div>
        <?php
          }
          ?>
          <div class="col-12 more-btn" style="text-align: center; padding-top:15px">
            <a href="?page=show" style="text-decoration: none; color: black;" class="more-link">More product &#10148;</a>
          </div>
        </div>
      </div>
    </div>
    <h2 style="text-align: center;padding-top:50px; padding-bottom: 20px;">// LEGO //</h2>
    <div class="container-fluid">
        <div class="row"> 
        <?php

		  	$result = mysqli_query($conn, "SELECT * FROM shirt where Cat_ID = 'C02'" );
			
			if (!$result) {
                die('Invalid query: ' . mysqli_error($conn));
                }					            
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			?>          
          <div class="col-lg-3 	col-md-4 col-sm-6 col-12 content-item">                       
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
        <div class="col-12 more-btn" style="text-align: center; padding-top:15px">
            <a href="?page=polo" style="text-decoration: none; color: black;" class="more-link">More Lego &#10148;</a>
          </div>
      </div>
    </div>

    <h2 style="text-align: center;padding-top:50px;  padding-bottom: 20px;">// Robot //</h2>
    <div class="container-fluid">
        <div class="row"> 
        <?php

		  	$result = mysqli_query($conn, "SELECT * FROM shirt where Cat_ID = 'C01'" );
			
			if (!$result) {
                die('Invalid query: ' . mysqli_error($conn));
                }					            
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			?>          
          <div class="col-lg-3 	col-md-4 col-sm-6 col-12 content-item">                       
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
          <div class="col-12 more-btn" style="text-align: center; padding-top:15px">
            <a href="?page=tshirt" style="text-decoration: none; color: black;" class="more-link">More Robot &#10148;</a>
          </div>
        </div>
      </div>
      <div class="container-fluid" style="padding-top: 50px;">
          <hr>
          <div style="position: absolute;" class="bttm-content">
            <h1>"N-SHIRT IS THE BEST RETAIL ONLINE SHOP"</h1>
            <p style="font-size: larger;">contact us with</p>
            <div class="social">
              <a href="https://www.facebook.com/" class="fa fa-facebook"></a>
              <a href="https://twitter.com/" class="fa fa-twitter"></a>
              <a href="https://www.instagram.com/" class="fa fa-instagram"></a>
            </div>
          </div>
          <div class="col-12"><img src="./Img/bottomctent.jpg" alt="" style="width: 100%; height:500px;"></div>      
      </div>
    </div>

</div>
<script src="./OwlCarousel/docs/assets/vendors/jquery.min.js"></script>
<script src="./OwlCarousel/dist/owl.carousel.min.js"></script>
<script>
    $(document).ready(function(){
    $(".owl-carousel").owlCarousel();
    });

    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    autoplayTimeout:1800,
    autoplayHoverPause:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
</script>


