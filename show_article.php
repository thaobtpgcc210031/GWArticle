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
        $sql = "SELECT magazine.*, contributions.ImgCv, contributions.title 
        FROM magazine 
        LEFT JOIN contributions ON magazine.ContributionID = contributions.ContributionID 
        LIMIT $offset, $per_page";

        $result = mysqli_query($conn, $sql);

        // Hiển thị dữ liệu
        if ($result && mysqli_num_rows($result) > 0) { // Thêm kiểm tra $result
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<a href='?page=detail_article&&id=" . $row['MagazineID'] . "' class='article'>";
                echo "<h2>" . $row['MagazineID'] . "</h2>";
                echo "<p>" . $row['ContentM'] . "</p>";
                // Hiển thị tên hình ảnh nếu có
                if ($row['ImgCv']) {
                    echo "<p>Tên hình ảnh: " . $row['ImgCv'] . "</p>";
                } else {
                    echo "<p>Không có hình ảnh.</p>";
                }
                // Hiển thị tiêu đề nếu có
                if ($row['title']) {
                    echo "<p>Tiêu đề: " . $row['title'] . "</p>";
                }
                echo "</a>";
            }
        } else {
            echo "Không có bài báo nào.";
        }
        

        // Truy vấn số lượng bài báo
        $sql_total = "SELECT COUNT(*) AS total FROM magazine";
        $result_total = mysqli_query($conn, $sql_total);
        $row_total = mysqli_fetch_assoc($result_total);
        $total_articles = $row_total['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_articles / $per_page);

        // Hiển thị các liên kết phân trang
        echo "<div class='pagination'>";
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
</div>
