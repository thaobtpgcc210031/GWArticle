<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (array_key_exists('UserID', $_FILES) and ($_POST['Username'] != '') and ($_POST['AcaYear'] != '') and ($_POST['Email'] != '')) 
{

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$mail = new PHPMailer(true);

$msg = '';

/* Khu vực chỉnh sửa nội dung email gửi dạng HTML ************************/
/* Khu vực chỉnh sửa nội dung email gửi dạng HTML ************************/

$text_email ="<table align='center' buserName = '0' style='background-color:#EED2EE'>";
$text_email =$text_email."<tr >";
$text_email =$text_email."	<td>";
$text_email =$text_email."		<h3 style='color:#ADFF2F'>CÔNG TY SHARECODE.VN</h3>";
$text_email =$text_email."		<h3 style='color:#0000FF'>lord boss</h3>";
$text_email =$text_email."	</td>";
$text_email =$text_email."	</tr>";
$text_email =$text_email."	";
$text_email =$text_email."	<tr style='font-size:medium'>";
$text_email =$text_email."	<td>";
$text_email =$text_email."		<p>Xin chào quý khách,</p>";
$text_email =$text_email."		<p>Đơn hàng mua vé trực tuyến qua hệ thống sharecode.vn của quý khách đã được xác nhận thanh toán thành công.</p>";
$text_email =$text_email."		<h4>Thông tin như sau:</h4>";
$text_email =$text_email."	</td>";
$text_email =$text_email."	</tr>";
$text_email =$text_email."	";
$text_email =$text_email."	<tr align='center'>";
$text_email =$text_email."	<td>";
$text_email =$text_email."		<h3>Mã đơn hàng:<span style='color:#FF3030'> ".$_POST['Username']."</span></h3>";
$text_email =$text_email."		<h3>Giá:<span style='color:#FF3030'> ".$_POST['AcaYear']."</span></h3>";
$text_email =$text_email."		<p>Quý khách có thể vào đường link sau để in vé : <a target='_blank' href='https://https://sharecode.vn/'>SHARECODE XUẤT LẠI VÉ</a></p>";
$text_email =$text_email."	</td>";
$text_email =$text_email."	</tr>";
$text_email =$text_email."	";
$text_email =$text_email."	<tr style='font-size:medium'>";
$text_email =$text_email."	<td>";
$text_email =$text_email."		<p>Tệp chứa vé điện tử được gửi kèm email này. Quý khách có thể đem đến phòng vé gần nhất để in vé hoặc dùng trực tiếp file vé để làm thủ tục lên tàu.</p>";
$text_email =$text_email."		<p>Quý khách vui lòng đến bến tàu 45 phút trước giờ khởi hành ghi trên vé và chuẩn bị đầy đủ giấy tờ xác thực cần thiết.</p>";
$text_email =$text_email."		<p>Công ty Sharecode kính chúc quý khách có một ngày tốt lành và hạnh phúc!</p>";
$text_email =$text_email."	</td>";
$text_email =$text_email."	</tr>";
$text_email =$text_email."	";
$text_email =$text_email."	<tr align='center'>";
$text_email =$text_email."	<td>";
$text_email =$text_email."		<p>--</p>";
$text_email =$text_email."		<p style='color:#ADFF2F'>Hộp thư trực tuyến - Công ty Sharecode.vn</p>";
$text_email =$text_email."		<p style='color:#0000FF'>Sharecode.contact@gmail.com</p>";
$text_email =$text_email."		<p>--</p>";
$text_email =$text_email."		<p>Quý khách vui lòng liên hệ phòng vé gần nhất để được hỗ trợ khi có nhu cầu huỷ đổi vé.</p>";
$text_email =$text_email."		<p></p>";
$text_email =$text_email."		<p style='color:#0000FF'>Phòng vé A: 0901.111.222</p>";
$text_email =$text_email."		<p>Phòng vé X: 0901.111.888</p>";
$text_email =$text_email."		<p style='color:#0000FF'>Phòng vé B: 0901.111.333</p>";
$text_email =$text_email."		<p>Phòng vé Y: 0901.111.999</p>";
$text_email =$text_email."		<p style='color:#0000FF'>Phòng vé C: 0962.111.444</p>";
$text_email =$text_email."		<p>Phòng vé Z: 0901.111.000</p>";
$text_email =$text_email."		<p style='color:#0000FF'>Phòng vé D: 0906.111.555</p>";
$text_email =$text_email."	</td>";
$text_email =$text_email."	</tr>";
$text_email =$text_email."	</table>";

/*KẾT THÚC KHU VỰC SỬA NỘI DUNG MAIL****************************************8*/
/*KẾT THÚC KHU VỰC SỬA NỘI DUNG MAIL****************************************8*/

try {
    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Mailer = "smtp";                                            // Send using SMTP
	
/**** CHỈNH SỬA CẤU HÌNH CHO EMAIL GỬI ĐI *****************************************************************************/
/**** CHỈNH SỬA CẤU HÌNH CHO EMAIL GỬI ĐI *****************************************************************************/

    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	$mail->Username   = 'nghiepndgcc210008@fpt.edu.vn';      //lấy email của mình               // SMTP username
    $mail->Password   = 'bruinfywxlyqcyog';                 //setup ggacount để lấy password         // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged   PHPMailer::ENCRYPTION_STARTTLS
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	
	$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

 /***THIẾT LẬP THÔNG TIN GỬI ĐI *****************************/
 /***THIẾT LẬP THÔNG TIN GỬI ĐI *****************************/
 
    $mail->setFrom('nghiepndgcc210008@fpt.edu.vn', 'Mailer');
    $mail->addAddress($_POST['Email']);     
    //$mail->addAddress('');               
    $mail->CharSet = "UTF-8";               
    //$mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
    //$mail->addBCC('DIA_CHI_EMAIL_GUI_BCC');


    // Content
    $mail->isHTML(true);                                  // Set email format to HTML

/*******NỘI DUNG EMAIL********************************/	
    $mail->Subject = 'TIEU_DE_EMAIL_CAN_GUI';
    $mail->Body    = $text_email;
    $mail->AltBody = 'ALT_TIEU_DE_EMAIL';


	//Attach multiple files one by one
    for ($ct = 0; $ct < count($_FILES['UserID']['tmp_name']); $ct++) 
	{
        $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['UserID']['name'][$ct]));
        $filename = $_FILES['UserID']['name'][$ct];
        if (move_uploaded_file($_FILES['UserID']['tmp_name'][$ct], $uploadfile))
		{
            $mail->addAttachment($uploadfile, $filename);
        } else 
		{
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
    }
    //Tạm thời không send
	$mail->send();
	
	
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



}
else 
{
	echo "Thiếu mã đơn hàng hoặc thiếu giá";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PHPMailer Upload</title>
</head>
<body>
<?php if (empty($msg)) { ?>
    <form method="post" enctype="multipart/form-data">
        Chọn file vé đính kèm gửi cho khách:
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <input name="UserID[]" type="file" multiple="multiple">
		
        <input type="text" name='Username' placeholder="Nhập mã đơn hàng">
        <input type="text" name= 'AcaYear' placeholder="Nhập trị giá đơn hàng">
		
        <input type="email" name= 'Email' placeholder="Nhập email khách hàng">
        
		<input type="submit" value="GỬI EMAIL">
    </form>
<?php } 
	else 
	{
    echo $msg;
	} 
?>
</body>
</html>
 