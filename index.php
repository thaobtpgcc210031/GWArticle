<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./Css/style.css">
    <link rel="stylesheet" href="./Css/contentstyle.css">
    <link rel="stylesheet" href="./Css/contentmiddle.css">
    <link rel="stylesheet" href="./Css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>N-shirt shop - Welcome</title>
  </head>
  <style>
    .grid-container{
      display: grid;
      grid-template-columns: 100px 268px;
      grid-template-rows: 60px;
      color: black;
    }
    .item1{
      grid-row: 1 / 3;
    }
    .item3{
      text-align: right;
    }

    h3{
      margin: 0;
      font-size: 20px;
      padding-top: 10px;
    }


    
    
  </style>
  <?php
  session_start();
  include_once("connection.php");
  //echo $_SESSION['admin'];
  
  ?>
  <body class="p-3 m-0 border-0">
    <nav class="navbar navbar-expand-lg" >
      <div class="container-fluid">
        <a class="navbarbrand" href="#" style="color: black;">ATN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="?page=home" style="font-weight: bold;">HOME</a>
            </li>
            <?php
              if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"style="font-weight: bold;">
              MANAGEMENT
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=product"style="font-weight: bold;">Product</a></li>
                <li><a class="dropdown-item" href="?page=category"style="font-weight: bold;">Category</a></li>
              </ul>
            </li>
            <?php
              
              }elseif(isset($_SESSION['admin']) && $_SESSION['admin'] == 0){
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"style="font-weight: bold;">
              CATEGORY
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=tshirt"style="font-weight: bold;">Robot</a></li>
                <li><a class="dropdown-item" href="?page=polo"style="font-weight: bold;">Lego</a></li>
                <li><a class="dropdown-item" href="?page=show"style="font-weight: bold;">All..</a></li>

              </ul>
            </li>

            <?php
            }else{
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"style="font-weight: bold;">
              CATEGORY
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=tshirt"style="font-weight: bold;">T-Shirt</a></li>
                <li><a class="dropdown-item" href="?page=polo"style="font-weight: bold;">Polo</a></li>
                <li><a class="dropdown-item" href="?page=sweater"style="font-weight: bold;">Sweater</a></li>
                <li><a class="dropdown-item" href="?page=henley"style="font-weight: bold;">Henleys</a></li>
                <li><a class="dropdown-item" href="?page=show"style="font-weight: bold;">All..</a></li>
              </ul>
            </li>
            <?php
            }
            ?>
            <li class="nav-item">
              <a class="nav-link active" href="#"style="font-weight: bold;">ABOUT US</a>
            </li>
          </ul>
          <ul class="navbar-nav mb-2 mb-lg-0">
          <?php
          if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
          if(isset($_SESSION['us']) && $_SESSION['us'] != ""){
          ?>
          <li class="nav-item">
              <a class="nav-link active" href="?page=account" style="font-weight: bold; color:#008000;">Hi, <?php echo $_SESSION['us']?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="logout.php">Logout</a>
            </li>
          <?php
          }
        }elseif(isset($_SESSION['admin']) && $_SESSION['admin'] == 0){
          
          if(isset($_SESSION['us']) && $_SESSION['us'] != ""){
          ?> 
          <form method="post" action="index.php?page=search">
	          <input id="searching" name="searching" type="search" placeholder="Search..." pattern=".*\S.*" required style="margin-top: 5px; width:500px;">
            <button type="submit" name="search-btn" style="margin-right: 70px">Search</button>
            <?php
              if(isset($_POST['search-btn'])){
                $searching = $_POST['searching'];
                
              }              
            ?>

            
          </form>
          <li class="nav-item" style="font-weight:bolder;">
            <a href="?page=cart">
              <div class="dropdownn">          
              <i class="fa-sharp fa-solid fa-cart-shopping fa-lg cart-hver" style="font-size: 28px;"></i>
                <div class="dropdown-content" style="width: 400px;">
                <?php
                      $result = mysqli_query($conn, "SELECT * FROM theCart where userName = '" .$_SESSION["us"]. "'");
                      while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
                  ?>
                <div class="grid-container">
                  <div class="cart-item item1"><img src="./Img/<?php echo $row['cart_Img']; ?>" alt="" style="border-radius: 0;" width="100%" height="100%"></div>
                  <div class="cart-item item2"><h3><?php echo $row['pro_Name']; ?></h3>Quantity: <?php echo $row['cart_Qty']; ?><h3></div>
                  <div class="cart-item item3">Total: <?php echo $row['total_Price']; ?>.00$</div>
                </div>
                <?php
                  }
                ?>
                </div>            
              </div>
            </a>
            </li>
          
            <li class="nav-item" style="margin-right: 30px; font-weight:bolder;">
              <a class="nav-link active" href="?page=account" style="">Hi, <?php echo $_SESSION['us']?></a>
            </li>
            <li class="nav-item" style="margin-right: 30px;font-weight:bolder;">
              <a class="nav-link active" href="logout.php">Logout</a>
            </li>
            <li class="nav-item" style="margin-right: 30px; margin-top:8px;font-weight:bolder;">
              <a href="#" style="text-decoration: none; color:black;"><i class="fa-regular fa-circle-question" style="color: black;"></i> Help</a>
            </li>
          
            
          <?php 
        }}else{
          ?>
          <form method="post" action="index.php?page=search">
	          <input id="searching" name="searching" type="search" placeholder="Search..." pattern=".*\S.*" required style="margin-top: 5px; width:500px;">
            <button type="submit" name="search-btn" style="margin-right: 70px">Search</button>
            <?php
              if(isset($_POST['search-btn'])){
                $searching = $_POST['searching'];
                
              }              
            ?>

            
          </form>

            <div class="dropdownn">
            <a href="login.php" role="button" >
            <i class="fa-sharp fa-solid fa-cart-shopping fa-lg cart-hver" style="font-size: 28px;"></i></a>
              <div class="dropdown-content">
                <p>Login to add the product to your cart!</p>
              </div>
            
            </div>
            
            <li class="nav-item" style="margin-right: 30px;font-weight:bolder;">
              <a class="nav-link active" href="login.php">Login</a>
            </li>
            <li class="nav-item" style="margin-right: 30px;font-weight:bolder;">
              <a class="nav-link active" href="register.php">Register</a>
            </li>
            <li class="nav-item" style="margin-right: 30px; margin-top:8px;font-weight:bolder;">
              <a href="#" style="text-decoration: none; color:black;"><i class="fa-regular fa-circle-question" style="color: black;"></i> Help</a>
            </li>
          <?php
          }?>
          </ul>
        </div>
      </div>
    </nav>
    <hr class="hrr" width="100%" align="center" />


    <?php
    include_once("connection.php"); 
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page=="category"){
            include_once("category.php");
        }
        if($page=="product"){
          include_once("product.php");
        }
        if($page=="add_category"){
          include_once("add_category.php");
        }
        if($page=="update_category"){
          include_once("update_category.php");
        }
        if($page=="add_product"){
          include_once("add_product.php");
        }
        if($page=="update_product"){
          include_once("update_product.php");
        }
        if($page=="back"){
          include_once("content.php");
        }
        if($page=="home"){
          include_once("content.php");
        }
        if($page=="detail_product"){
          include_once("detail_product.php");
        }
        if($page=="show"){
          include_once("show_product.php");
        }
        if($page=="polo"){
          include_once("polo.php");
        }
        if($page=="tshirt"){
          include_once("tshirt.php");
        }
        if($page=="account"){
          include_once("account.php");
        }
        if($page=="cart"){
          include_once("cart.php");
        }
        if($page=="search"){
          include_once("search.php");
        }
    }else{
        include_once("content.php");
    }


    
    ?>

    <footer class="text-center text-lg-start bg-white text-muted" >
      <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom" >
      </section>

      <section class="" >
        <div class="container text-center text-md-start mt-5" >
          <!-- Grid row -->
          <div class="row mt-3">
            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
              <!-- Content -->
              <h6 class="text-uppercase fw-bold mb-4">
                <i class=""></i>ATN
              </h6>
              <p>
              This is an online sales website with great toys.
              
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
              <h6 class="text-uppercase fw-bold mb-4">
                Products
              </h6>
              <p>
                <a href="#!" class="text-reset" style="text-decoration: none;">Robot</a>
              </p>
              <p>
                <a href="#!" class="text-reset" style="text-decoration: none;">Lego</a>
              </p>
            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
              <h6 class="text-uppercase fw-bold mb-4">
                Useful
              </h6>
              <p>
                <a href="#!" class="text-reset" style="text-decoration: none;">Pricing</a>
              </p>
              <p>
                <a href="#!" class="text-reset" style="text-decoration: none;">Settings</a>
              </p>
              <p>
                <a href="#!" class="text-reset" style="text-decoration: none;">Orders</a>
              </p>
              <p>
                <a href="#!" class="text-reset" style="text-decoration: none;">Help</a>
              </p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
              <!-- Links -->
              <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
              <p><i class="fas fa-house me-3 text-secondary" style="color: #000000;"></i></i> Can Tho,VN</p>
              <p>
                <i class="fas fa-envelope me-3 text-secondary"></i>
                nghiepndgcc210008@fpt.edu.vn
              </p>
              <p><i class="fas fa-phone me-3 text-secondary"></i> +84 000 000 00</p>
            </div>
          </div>
        </div>
      </section>
      <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.025);">
        © 2022 N-Shirt fashion store
      </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>