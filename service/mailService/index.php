<?php
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
include_once '../../database/Product.php';
include_once '../../database/UserAccount.php';

$jsontext = fopen("../../shop_detail.json", "r");
$json = (array)json_decode(fread($jsontext, filesize("../../shop_detail.json")));
fclose($jsontext);




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
$product = new Product();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Port = "587";
$mail->Username = $json['sender_email'];
$mail->Password = $json['sender_password'];
$mail->Subject = "รายงานสินค้าใกล้หมด";
$mail->setFrom($json['sender_email']);
$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$body = '';
$lost = $product->fetchLost();
if(count($lost)>0){
    foreach ($lost as $row) {
        if ($row['product_rm_unit'] > 0) {
            $body .= $row['product_name'] . ' คงเหลือ ' . $row['product_rm_unit'] . " "
                . $row['product_unit'] . "<br/>";
        } else {
            $body .= $row['product_name'] . ' หมด ' . "<br/>";
        }
    }
}else{
    $body = 'ไม่มีสินค้าใกล้หมด';
}

$useraccount = new UserAccount();
$user = $useraccount->fetchAll();
foreach ($user as $row){
    if($row['account_user_type'] != "A") {
        $u = "";
        $u = $row['account_username'];
        $mail->Body = $body;
        $mail->addAddress($u);
    }
}

/*
$mail->Body = $body;
$mail->addAddress($json['res_email']);
$mail->addAddress($json['res_email2']);
*/

if ($mail->send()) {
    echo "Email Sent..!";
} else {
    echo "Message could not be sent. Mailer Error: $mail->ErrorInfo";
}
$mail->smtpClose();
