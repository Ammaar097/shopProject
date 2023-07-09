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
    <link rel="stylesheet" href="./src/css/vat.css" />

</head>
<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['shop_name'])) {
    $name = "ร้าน ABC";
} else {
    $name =  $_SESSION['shop_name'];
}
if (isset($_POST['shop_name'])) {
    $_SESSION['shop_name'] = $_POST['shop_name'];
}
include_once('nav.php'); ?>

<body>
    <form method="post" action="name.php">
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>ตั้งค่าชื่อร้าน</h1>
                    <table class="main col-10">
                        <tr>
                            <th>ชื่อร้าน &nbsp<input type="text" name="shop_name" id="shop_name" value="<?= $name; ?>" required></th>
                        </tr>
                    </table>
                    <div class="row btn-g">
                        <div class="col-2">
                            <!--<button type="reset" class="btn-c reset">ยกเลิก</button>-->
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn-c submit" value="บันทึก" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>