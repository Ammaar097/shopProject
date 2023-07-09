<?php
$jsontext = fopen("shop_detail.json", "r");
$json = (array) json_decode(fread($jsontext,filesize("shop_detail.json")));
fclose($jsontext);
?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="./src/css/nav2.css" />
<title><?=$json['shop_name']?></title>
<link rel="shortcut icon" href="./src/images/892917.ico" />

<body>
    <form>
        <div class="navbar">
            <a class="n" href="customer.php" style="font-size: 24px; margin-top: auto;">หน้าแรก</a>
            <form method="GET" action="customer.php">
                <div class="m"><input style="font-size: 18pt;" name="keyword" type="text" class="d" placeholder="&nbsp ชื่อสินค้า" /><button type="submit" style="background: transparent; border: 0;"><i class="fa fa-fw fa-search" style="font-size: 18pt;"></i> </button></div>
            </form>
            <a href="login.php"><i class="fa fa-fw fa-user"></i>Login</a>
        </div>
    </form>
</body>

</html>