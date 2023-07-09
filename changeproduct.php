<?php
include_once('service/auth.php');
isLaber();
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
    <link rel="stylesheet" href="./src/css/changeproduct.css" />

</head>
<?php
if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION['day_change'])) {
    $_SESSION['day_change'] = 7;
}
if (isset($_POST['day_change'])) {
    $_SESSION['day_change'] = $_POST['day_change'];
}
include_once('nav.php'); ?>

<body>
    <form action="changeproduct.php" method="post" id="form1" name="form1">
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>ตั้งค่าการเปลี่ยนสินค้า</h1>
                    <table class="main col-10">
                        <tr>
                            <th>ระยะเวลาที่รับเปลี่ยนสินค้า &nbsp<input type="text" name="day_change" id="day_change" style="width: 3%; text-align: right;" value="<?= $_SESSION['day_change']; ?> ">
                                &nbsp วัน
                            </th>
                        </tr>
                    </table>
                    <div class="row btn-g">
                        <!--<div class="col-2">
                        <button type="reset" class="btn-c reset" >ยกเลิก</button>
                    </div>-->
                        <div class="col-2">
                            <button type="button" class="btn-c submit" onclick="Submit()" value="บันทึก">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./src/js/changeproduct.js"></script>

</html>