<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paper Website Information Page</title>
</head>
<style>
    /* Resetting default margin and padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    /* Basic styling */
    nav ul {
        list-style-type: none;
    }
    nav ul li a {
        text-decoration: none;
        color: #fff;
    }
    h2 {
        color: #333;
    }

    form label {
        display: block;
        margin-bottom: 5px;
    }

    form input[type="text"],
    form input[type="email"],
    form textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
    }

    form button {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
    }
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #fff;
    }

    .article {
        width: 80%;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .left-panel {
        flex: 1;
        padding: 20px;
    }

    .left-panel img {
        width: 100%;
        border-radius: 5px;
    }

    .middle-panel {
        flex: 2;
        padding: 20px;
    }

    .right-panel {
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .pdf-link {
        margin-top: auto;
    }

    .pdf-link a {
        display: block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .pdf-link a:hover {
        background-color: #0056b3;
    }

    .article-image {
        margin-top: 20px;
        max-width: 60%;
        height: auto;
        text-align: center;
        border: 2px solid black;
    }
</style>
<main>
<?php
include_once("connection.php");
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $result = mysqli_query($conn, "SELECT magazine.*, contributions.ImgCv, contributions.title, contributions.ImgSample,contributions.ContentP  
    FROM magazine LEFT JOIN contributions ON magazine.ContributionID = contributions.ContributionID WHERE MagazineID = '$id'");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $price = $row['MagazineID'];
    $name = $row['ContentM'];
    $image = $row['ImgCv'];
    $sampleimg = $row['ImgSample'];
    $content = $row['ContentP'];
    //echo $_SESSION['us'];
}
// if(isset($_POST['btnAddCart'])){
//     $qty=$_POST['txtAmount'];
//     $usrname = $_SESSION['us'];
//     $sz = $_POST['size'];
//     if($sz != "size"){
//         if($qty !=""){
//         $total = $price * $qty;
//         $sz = $_POST['size'];
//         mysqli_query($conn, "INSERT INTO theCart (pro_Name, size, cart_Qty, date, userName ,total_Price, cart_Img)
//                             VALUES ('$name','$sz' ,'$qty','".date('Y-m-d H:i:s')."','$usrname','$total','$image')") or die(mysqli_error($conn));
//         echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';                
//         }else{
//             echo'<li>enter quantity</li>';
//         }            
//     }else{
//        echo '<li>choose size</li>';             
//     }        
// }
?>
    <div class="container">
        <div class="article">
            <div class="left-panel">
                <img src="./Img/<?php echo $image ?>" alt="Cover page">
            </div>
            <div class="middle-panel">
                <h1><?php echo $name;?></h1>
                <p><?php echo $content ?></p>
               
            </div>
            <div class="right-panel">
                <div class="pdf-link">
                    <a href="download.php?file=example.pdf" target="_blank">Download PDF</a>
                </div>
            </div>
        </div>
        <div class="article-image">
            <img src="./Img/<?php echo $sampleimg ?>" alt="Sample">
        </div>
    </div>
    <section>
        <h2>Feedback</h2>
        <p>If you have any questions, suggestions, or feedback for this article, please type here.</p>
        <form action="#" method="post">
            <label for="message" style="font-weight:bold; font-size: 20px;">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>
            <button type="submit">Send</button>
        </form>
    </section>
</main>