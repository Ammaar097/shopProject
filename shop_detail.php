<?php
include_once('service/auth.php');
isAdmin();
function getFullRole($role)
{
    if ($role == "E") {
        return 'พนักงาน';
    }
    if ($role == "L") {
        return 'เจ้าของร้าน';
    }
    if ($role == "A") {
        return 'ผู้ดูแลระบบ';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/shop_detail.css" />
    
</head>
<?php
$jsontext = fopen("shop_detail.json", "r");
$json = (array) json_decode(fread($jsontext,filesize("shop_detail.json")));
fclose($jsontext);

if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION['address'])) {
    $_SESSION['address'] = 'xxxxxxxxx';
}
if (isset($_POST['address'])) {
    $_SESSION['address'] = $_POST['address'];
}
if (!isset($_SESSION['vat_no'])) {
    $_SESSION['vat_no'] = "xxxxxxxxxxxxx";
}
if (isset($_POST['vat_no'])) {
    $_SESSION['vat_no'] = $_POST['vat_no'];
}
if (!isset($_SESSION['tel'])) {
    $_SESSION['tel'] = "xxxxxxxx";
}
if (isset($_POST['tel'])) {
    $_SESSION['tel'] = $_POST['tel'];
}
if (!isset($_SESSION['shop_name'])) {
    $_SESSION['shop_name'] = "วรเชษฐ์เกษตรภัณฑ์";
}
if (isset($_POST['shop_name'])) {
    $_SESSION['shop_name'] = $_POST['shop_name'];
    $json['shop_name'] = $_POST['shop_name'];
}

if (isset($_POST['sender_email'])) {
    if(strstr($_POST['sender_email'],"@gmail.com") != false){
        $json['sender_email'] = $_POST['sender_email'];
    }else{
        echo '<script> alert("Gmail เท่านั้น")</script>';
    }
}
if (isset($_POST['sender_password'])) {
    $json['sender_password'] = $_POST['sender_password'];
}
if (isset($_POST['res_email'])) {
    $json['res_email'] = $_POST['res_email'];
}
if (isset($_POST)) {
    $jsontext = fopen("shop_detail.json", "w");
    fwrite($jsontext, json_encode($json));
    fclose($jsontext);
}

include_once('nav.php'); ?>

<body>
<form method="post" action="shop_detail.php" id="form1" name="form1">
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <h1>ตั้งค่าข้อมูลร้านค้า</h1>
                <table class="main col-10">
                    <tr>
                        <th>ชื่อร้าน : &nbsp<input class="sn" type="text" name="shop_name" id="shop_name" value="<?=  $_SESSION['shop_name'];?>" required></th>
                    </tr>
                    <tr>
                        <th>ที่อยู่ : &nbsp<input class="ar" type="text" name="address" id="address" value="<?= $_SESSION['address']; ?>"> &nbsp </th>
                    </tr>
                    <tr>
                        <th>เลขประจำตัวผู้เสียภาษี : &nbsp<input class="vn" type="text" name="vat_no" id="vat_no" value="<?= $_SESSION['vat_no']; ?>"> &nbsp </th>
                    </tr>
                    <tr>
                        <th>เบอร์โทรติดต่อ : &nbsp<input class="tel" type="text" name="tel" id="tel" value="<?= $_SESSION['tel']; ?>"> &nbsp </th>
                    </tr>
                    <tr>
                        <th>อีเมลส่งการแจ้งเตือน (Gmail เท่านั้น) : &nbsp<input class="email" type="email" name="sender_email" id="sender_email" value="<?= $json['sender_email']; ?>"> &nbsp </th>
                    </tr>
                    <tr>
                        <th>รหัสผ่านอีเมลส่งการแจ้งเตือน  : &nbsp<input class="sp" type="password" name="sender_password" id="sender_password" value="<?= $json['sender_password']; ?>"> &nbsp </th>
                    </tr>
                </table>
                <div class="row btn-g">
                    <div class="col-2">
                    <button type="button" class="btn-c submit" onclick="Submit()" value="บันทึก">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
<script src="./src/js/shop_detail.js"></script>
</html>