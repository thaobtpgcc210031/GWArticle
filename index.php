<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./Css/style.css">
  <link rel="stylesheet" href="./Css/contentstyle.css">
  <link rel="stylesheet" href="./Css/contentmiddle.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="icon" href="./Icon/icon.ico" type="image/x-icon">
  <title>GW Magazine - Welcome</title>
</head>
<style>
  .grid-container {
    display: grid;
    grid-template-columns: 100px 268px;
    grid-template-rows: 60px;
    color: black;
  }

  .item1 {
    grid-row: 1 / 3;
  }

  .item3 {
    text-align: right;
  }

  h3 {
    margin: 0;
    font-size: 20px;
    padding-top: 10px;
  }

  .search-container {
    align-items: center;
    width: 400px;
    
  }

  input[type="text"] {
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 25px;
    background-color: #f2f2f2;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    outline: none;
    transition: background-color 0.3s ease;
    width: 100%;
  }

  input[type="text"]:focus {
    background-color: #e6e6e6;
  }
  input[type="password"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #D3D3D3;
    border-radius: 5px;
    background-color: #f2f2f2;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    outline: none;
    transition: background-color 0.3s ease;
    width: 100%;
  }

  input[type="password"]:focus {
    background-color: #e6e6e6;
  }

  button {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 25px;
    background-color: #333;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  button:hover {
    background-color: #0056b3;
  }
</style>
<?php
session_start();
include_once("connection.php");
// echo $_SESSION["fullName"];
// echo $_SESSION["us"];
// echo $_SESSION["role"];

?>

<body class="p-3 m-0 border-0">
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbarbrand" href="#" style="color: black;">GW</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="?page=home" style="font-weight: bold;">HOME</a>
          </li>
          <?php
          if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                ARTICLE
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" style="font-weight: bold;">School</a></li>
                <li><a class="dropdown-item" href="#" style="font-weight: bold;">Social</a></li>
                <li><a class="dropdown-item" href="#" style="font-weight: bold;">All..</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                CONTRIBUTIONS
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=addcontri" style="font-weight: bold;">Submit</a></li>
                <li><a class="dropdown-item" href="#" style="font-weight: bold;">Your Submit</a></li>
              </ul>
            </li>
          <?php

          } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 3) {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                MANAGE CONTRIBUTIONS
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?page=submit" style="font-weight: bold;">View Contribution</a></li>
                <li><a class="dropdown-item" href="?page=polo" style="font-weight: bold;">Social</a></li>
                <li><a class="dropdown-item" href="?page=show" style="font-weight: bold;">All..</a></li>
              </ul>
            </li>
          <?php
          }  elseif (isset($_SESSION['role']) && $_SESSION['role'] == 4) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                  MANAGERMENT
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="?page=article" style="font-weight: bold;">Article</a></li>
                  <li><a class="dropdown-item" href="?page=manage_account" style="font-weight: bold;">Account</a></li>

                  <li><a class="dropdown-item" href="?page=faculty" style="font-weight: bold;">Faculty</a></li>

                  <li><a class="dropdown-item" href="?page=feedback_manage" style="font-weight: bold;">Manage Feedback</a></li>



                  <li><a class="dropdown-item" href="?page=show" style="font-weight: bold;">All..</a></li>
  
                </ul>
              </li>
            <?php
            }
           elseif (isset($_SESSION['role']) && $_SESSION['role'] == 5) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                  MANAGE
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="?page=tshirt" style="font-weight: bold;">Contributions</a></li>
                  <li><a class="dropdown-item" href="?page=show" style="font-weight: bold;">Statistical</a></li> 
                </ul>
              </li>
            <?php
            }
           else {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                ARTICLE
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="login.php" style="font-weight: bold;">School</a></li>
                <li><a class="dropdown-item" href="login.php" style="font-weight: bold;">Social</a></li>
                <li><a class="dropdown-item" href="login.php" style="font-weight: bold;">All..</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight: bold;">
                CONTRIBUTIONS
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="login.php" style="font-weight: bold;">Submit</a></li>
                <li><a class="dropdown-item" href="login.php" style="font-weight: bold;">Your Submit</a></li>
              </ul>
            </li>
          <?php
          }
          ?>
          <li class="nav-item">
            <a class="nav-link active" href="?page=about" style="font-weight: bold;">ABOUT US</a>
          </li>

        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0">
          
          <?php
          if (isset($_SESSION['role']) && $_SESSION['role'] >= 1) {
          ?>
              <li class="nav-item">
                <a class="nav-link active" href="?page=account" style="font-weight: bold; color:#008080;">Hi, <?php echo $_SESSION['fullName'] ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" style="font-weight: bold;" href="logout.php">Logout</a>
              </li>
              <!-- </form>
              <li class="nav-item" style="margin-right: 30px; font-weight:bolder;">
                <a class="nav-link active" href="?page=account" style="">Hi, </a>
              </li>
              <li class="nav-item" style="margin-right: 30px;font-weight:bolder;">
                <a class="nav-link active" href="logout.php">Logout</a>
              </li>
              <li class="nav-item" style="margin-right: 30px; margin-top:8px;font-weight:bolder;">
                <a href="#" style="text-decoration: none; color:black;"><i class="fa-regular fa-circle-question" style="color: black;"></i> Help</a>
              </li> -->
            <?php
            
          } else {
            ?>


            </form>

            <div class="dropdownn">
              <a href="login.php" role="button">
              </a>
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
          } ?>
        </ul>
      </div>
    </div>
  </nav>
  <hr class="hrr" width="100%" align="center" />


  <?php
  include_once("connection.php");
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == "feedback") {
      include_once("feedback.php");
    }
    if ($page == "article") {
      include_once("article.php");
    }
    if ($page == "add_feedback") {
      include_once("add_feedback.php");
    }
    if ($page == "update_feedback") {
      include_once("update_feedback.php");
    }
    if ($page == "add_article") {
      include_once("add_article.php");
    }
    if ($page == "update_article") {
      include_once("update_article.php");
    }
    if ($page == "back") {
      include_once("content.php");
    }
    if ($page == "home") {
      include_once("content.php");
    }
    if ($page == "detail_article") {
      include_once("detail.php");
    }
    if ($page == "show") {
      include_once("show_article.php");
    }
    if ($page == "updateSubmit") {
      include_once("updateSubmit.php");
    }
    if ($page == "about") {
      include_once("about.php");
    }  
    if ($page == "contribution") {
      include_once("contribution.php");
    }
    if ($page == "account") {
      include_once("account.php");
    }
    if ($page == "submit") {
      include_once("submit.php");
    }
    if ($page == "search") {
      include_once("search.php");
    }
    if ($page == "manage_account") {
      include_once("manage_account.php");
    }
    if ($page == "addcontri") {
      include_once("add_contribution.php");
    }
    if ($page == "update_account") {
      include_once("update_account.php");
    }
    if ($page == "interact") {
      include_once("interact_faculty.php");

    }
  } else {
    include_once("content.php");
  }



  ?>

  <footer class="text-center text-lg-start bg-white text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    </section>

    <section class="">
      <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold mb-4">
              <i class=""></i>GW MAGEZINE
            </h6>
            <p>
              This is a page to show some article about eduction of schoole

          </div>

          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">
              Article
            </h6>
            <p>
              <a href="#!" class="text-reset" style="text-decoration: none;">Shool</a>
            </p>
            <p>
              <a href="#!" class="text-reset" style="text-decoration: none;">Social</a>
            </p>
          </div>

          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">
              Useful
            </h6>
            <p>
              <a href="#!" class="text-reset" style="text-decoration: none;">Article</a>
            </p>
            <p>
              <a href="#!" class="text-reset" style="text-decoration: none;">Settings</a>
            </p>
            <p>
              <a href="#!" class="text-reset" style="text-decoration: none;">Download</a>
            </p>
            <p>
              <a href="#!" class="text-reset" style="text-decoration: none;">Help</a>
            </p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-house me-3 text-secondary" style="color: #000000;"></i></i> Can Tho, Vietnam</p>
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