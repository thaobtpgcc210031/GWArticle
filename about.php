<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>An About Us Page | CoderGirl</title>
  <!-- Custom CSS File -->
  <link rel="stylesheet" href="style.css">
  <style>
    /* Custom Styles */
    body {
      background-color: #f9f9f9; /* Màu xám nhạt */
    }

    .about-us {
      height: 100vh;
      width: 100%;
      padding: 90px 0;
      background: linear-gradient(to right, #ff9a9e, #fecfef); /* Nền gradient */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .about {
      width: 90%;
      max-width: 1200px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-color: rgba(255, 255, 255, 0.9); /* Nền trắng có độ trong suốt */
      padding: 40px;
    }

    .text {
      width: 100%;
      text-align: center;
      color: #333; /* Màu chữ xám đậm */
    }

    .text h2 {
      font-size: 48px; /* Kích thước font giảm */
      font-weight: 700; /* Tăng độ đậm */
      margin-bottom: 20px; /* Tăng margin */
      color: #ff6b6b; /* Màu chữ đỏ */
    }

    .text h5 {
      font-size: 24px; /* Tăng kích thước font */
      font-weight: 500;
      margin-bottom: 30px; /* Tăng margin */
      color: #ff6b6b; /* Màu chữ đỏ */
    }

    .text p {
      font-size: 20px; /* Tăng kích thước font */
      line-height: 30px; /* Tăng line height */
      letter-spacing: 1.5px; /* Tăng khoảng cách chữ */
      margin-bottom: 40px; /* Tăng margin */
    }

    .data, .infor {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px; /* Tăng margin top */
    }

    .data a, .infor a {
      text-decoration: none;
      color: #fff; /* Màu chữ trắng */
      padding: 12px 30px; /* Tăng padding */
      border-radius: 5px; /* Góc cong */
      margin-right: 20px; /* Tăng margin */
      transition: all 0.3s ease; /* Hiệu ứng mượt */
    }

    .data a:hover, .infor a:hover {
      transform: translateY(-3px); /* Di chuyển lên trên khi hover */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Hiển thị đổ bóng */
    }

    .data a {
      background-color: #ff6b6b; /* Màu đỏ */
    }

    .data a:hover {
      background-color: #ff7e7e; /* Màu đỏ tối */
    }

    .infor a {
      background-color: #70a1ff; /* Màu xanh */
    }

    .infor a:hover {
      background-color: #7faeff; /* Màu xanh tối */
    }
  </style>
</head>
<body>
  <section class="about-us">
    <div class="about">
      <!--<img src="girl.png" class="pic">-->
      <div class="text">
        <h2>GW Article</h2>
        <h5>Welcome to my website <span>GW Article</span></h5>
        <p>This is an article to showcase some activities of the school and the faculty.</p>
        <div class="data">
          <a href="?page=home">Home Page</a>
        </div>
        <div class="infor">
          <a href="http://gmail.com">My Email</a>
          <a href="#">Phone: 0123456789</a>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
