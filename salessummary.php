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
    <link rel="stylesheet" href="./src/css/salessummary.css" />

</head>
<?php include_once('nav.php'); ?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>การขาย</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <h5 class="tt">สรุปยอดขาย</h5>
                        <div class="th"></div>
                    </div>
                </div>
                <div class="n">
                    <h5>ภาพรวมการขายสินค้า</h5>
                    <button type="button" class="btne" onclick="javascript:window.location='salesgraph.php';"><img src="./src/images/sale.png " width="35">&nbsp <h3>ยอดขาย</h3></button> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <button type="button" class="btne" onclick="javascript:window.location='salehistory.php';"><img src="./src/images/list.png" width="35">&nbsp <h3>รายการขาย</h3></button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>