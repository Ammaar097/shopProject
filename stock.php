<?php
include_once('service/auth.php');
isNotAdmin();
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
    <link rel="stylesheet" href="./src/css/stock.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


</head>
<?php include_once('nav.php');
include_once "./database/Product.php";
include_once "./database/Stock.php";
$stock =  new Stock();
$rows = $stock->fetchAll();
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col">
                    <h1>คลังสินค้า</h1>
                </div>
                <div class="col-2 addproducttypebutton">
                    <button class="submit btn" onclick="insert()"><img src="./src/images/plus.png" width="25">&nbsp เพิ่มคลังสินค้า</button>
                </div>
            </div>
            <table class="col-13 tbproducttype">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รายการสินค้า</th>
                        <th>รหัสใบสั่งซื้อ</th>
                        <th>วันหมดอายุ</th>
                        <th>จำนวน</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="stocktable">
                    <?php $i = 1;
                    foreach ($rows as $row) { ?>
                        <tr>
                            <th width=5%><?= $i ?></th>
                            <th width=35% id="text<?= $row['product_id'] ?>"><?= $row['product_name'] ?></th>
                            <th width=20%></th>
                            <th width=20%></th>
                            <th width=20%></th>
                            <th>
                                <button type="button" class="bgs" onclick="del(<?= $row['stock_id'] ?>)"><img src="./src/images/icon-delete.png" width="25"></button>
                                <button type="button" class="bgs" onclick="edit(<?= $row['stock_id'] ?>)"><img src="./src/images/icon-pencil.png" width="25"></button>
                            </th>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
        <script src="./src/js/stock.js"></script>

</html>
<!--
    แก้ ui ที่ต่อจากกดยืนยันการผ่อนชำระ
    เพิ่มการเชื่อมต่อทั้งข้อมูลและ modal
-->