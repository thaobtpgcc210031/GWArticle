<link rel="stylesheet" href="./OwlCarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="./OwlCarousel/dist/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="./Css/contentstyle.css">
<link rel="stylesheet" href="./Css/contentmiddle.css">
<style>
  
  /* Reset some default styles */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* Style for the section containing the slider */
section {
    margin-top: 20px;
}

/* Style for the search form */
form {
    margin-bottom: 20px;
    text-align: center;
}

.search-container {
    display: inline-block;
    margin-top: 10px;
}

#searchInput {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 5px;
}

#search-btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Style for the container of articles */
.container {
    width: 80%;
    margin: 0 auto;
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

.article-list {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 20px;
}

.article {
    padding: 10px;
    background-color: #f2f2f2;
    border-radius: 5px;
    text-decoration: none;
    color: #333;
}

.article:hover {
    box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
}

.article h2 {
    font-size: 18px;
    margin-bottom: 10px;
}

.article p {
    font-size: 14px;
    margin-bottom: 10px;
}

/* Style for pagination */
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination a {
    display: inline-block;
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 5px;
}

.pagination a:hover {
    background-color: #f2f2f2;
}

.pagination .current {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
    border-radius: 4px;
    padding: 8px 16px;
    margin-right: 5px;
}

  
</style>


<section>
    <div class="owl-carousel owl-theme">
        <div class="slide-item slItem_1"><img class="sl_img" src="./Img/slide1.png" alt=""></div>
        <div class="slide-item slItem_2"><img class="sl_img" src="./Img/slide2.png" alt=""></div>
        <div class="slide-item slItem_3"><img class="sl_img" src="./Img/slide3.png" alt=""></div>
        <div class="slide-item slItem_4"><img class="sl_img" src="./Img/slide4.png" alt=""></div>
    </div>
</section>
<form method="post" action="index.php?page=search">
              <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search...">
                <button type="submit" id="search-btn" class="search-btn">Search</button>
              </div>
              <?php
              if (isset($_POST['search-btn'])) {
                $searching = $_POST['searching'];
              }
              ?>
</form>
<br>
<style>
    .container {
        width: 80%;
        margin: 0 auto;
    }
    .article-list {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 20px;
    }
    .article {
        padding: 10px;
    }
</style>
<div class="container">
    <h1>List of Articles</h1>
    <div class="article-list">
        <?php
        if(isset($_GET['page']) && $_GET['page'] == 'show'){
            $show = $_GET['page'];
        }else{
            $show= '';
        }
        // Kết nối đến cơ sở dữ liệu
        include_once("connection.php");

        // Số bài báo trên mỗi trang
        $per_page = 8;

        // Trang hiện tại (mặc định là trang 1)
        $current_page = isset($_GET['page_number']) ? $_GET['page_number'] : 1;
        $current_page = intval($current_page);


        // Tính offset để truy vấn dữ liệu từ database
        $offset = ($current_page > 1) ? ($current_page - 1) * $per_page : 0;

        // Truy vấn dữ liệu từ database
        $sql = "SELECT *
        FROM contributions 
        LIMIT $offset, $per_page";

        $result = mysqli_query($conn, $sql);

        // Hiển thị dữ liệu
        if ($result && mysqli_num_rows($result) > 0) { // Thêm kiểm tra $result
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<a href='?page=detail_article&&id=" . $row['ContributionID'] . "' class='article'>";
                echo "<h2>" . $row['ContributionID'] . "</h2>";
                echo "<p>" . $row['Title'] . "</p>";
                // Hiển thị tên hình ảnh nếu có
                if ($row['ImgCv']) {
                    echo '<img style="width:100px; height:100px" src="./Img/' . $row["ImgCv"] . '" alt="Image">';
                    
                } else {
                    echo "<p>No Image.</p>";
                }
                // Hiển thị tiêu đề nếu có
                if ($row['ContentP']) {
                    echo "<p>Content: " . $row['ContentP'] . "</p>";
                }
                echo "</a>";
            }
        } else {
            echo "No contribution";
        }
        ?>
        </div>
        <?php

        // Truy vấn số lượng bài báo
        $sql_total = "SELECT COUNT(*) AS total FROM contributions";
        $result_total = mysqli_query($conn, $sql_total);
        $row_total = mysqli_fetch_assoc($result_total);
        $total_articles = $row_total['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_articles / $per_page);

        // Hiển thị các liên kết phân trang
        echo "<br><div class='pagination'>";
        if ($current_page > 1) {
            echo "<a href='index.php?page=show&page_number=1'>First</a>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $current_page) {
                echo "<span class='current'>$i</span>";
            } else {
                echo "<a href='index.php?page=show&page_number=$i'>$i</a>";
            }
        }
        if ($current_page < $total_pages) {
            echo "<a href='index.php?page=show&page_number=$total_pages'>Last</a>";
        }
        echo "</div>";

        ?>

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


