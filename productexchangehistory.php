<?php
include_once('service/auth.php');
include_once('service/dateFormat.php');
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
    <link rel="stylesheet" href="./src/css/productexchangehistory.css" />

</head>
<?php
include_once('nav.php');
include_once "./database/ProductExchange.php";
include_once "./service/datetimeDisplay.php";
$productexchange = new ProductExchange();
if (isset($_GET['start']) && isset($_GET['end']) && $_GET['start'] != '' && $_GET['end'] != '') {
    $rows = $productexchange->fetchBetween($_GET['start'], $_GET['end']);
} else if ((!isset($_GET['start']) && !isset($_GET['end'])) || ($_GET['start'] != '' && $_GET['end'] != '')) {
    $rows = $productexchange->fetchAll();
} else {
    $rows = [];
}
?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-5 d-flex justify-content-start">
                        <h1>การเปลี่ยนสินค้า</h1>
                    </div>
                    <div class="col-7 d-flex justify-content-end mai">
                        <form action="productexchangehistory.php" method="GET">
                            <div class="col">
                                <input value="<?= date('Y-m-d') ?>" value="<?= isset($_GET['start']) ? $_GET['start'] : '' ?>" class="date" type="date" name="start" id="start"> &nbsp&nbspถึง&nbsp&nbsp
                                <input value="<?= date('Y-m-d') ?>" value="<?= isset($_GET['end']) ? $_GET['end'] : '' ?>" class="date" type="date" name="end" id="end">
                                <button type="submit" class="s"><img src="./src/images/search.png" width="25"></button>
                                <button type="button" onclick="window.location= 'productexchangehistory.php'" class="btn-c reset">ล้างข้อมูล</button>
                                <a type="button" href="./searchinformation.php" class="submit btn"><img src="./src/images/plus.png" width="25" style="margin-top: -0.3rem;">&nbsp เพิ่ม</a>
                            </div>
                        </form>
                    </div>
                </div>
                    <?php if (count($rows) > 0) { ?>
                        <table class="pdrtb" >
                            <thead>
                                <tr>
                                    <th width=18%>วันที่เปลี่ยนสินค้า</th>
                                    <th width=18%>เวลาเปลี่ยนสินค้า</th>
                                    <th width=30%>ชื่อสินค้า</th>
                                    <th width=10%>จำนวน</th>
                                    <th width=15%>สถานะการเปลี่ยนสินค้า</th>
                                    <th width=10%><img src="./src/images/edit.png" width="25"></th>
                                </tr>
                            </thead>
                            <tbody id="productExchangeTable">
                                <?php foreach ($rows as $row) { ?>
                                    <tr>
                                        <th><?= dateTimeDisplay($row['exchange_date']) ?></th>
                                        <th><?= ShowTime($row['exchange_date']) ?></th>
                                        <th id="text<?= $row['product_id'] ?>"><?= $row['product_name'] ?></th>
                                        <th><?= number_format($row['exchange_amount']) ?></th>
                                        <th><?php if ($row['exchange_status'] == 1) { ?>
                                                <a type='button' onclick="wait(<?= $row['product_exchange_id']; ?>)">
                                                    <font color=#A36627>รอของ</font>
                                                </a>
                                            <?php } else { ?>
                                                สำเร็จ
                                            <?php } ?>
                                        </th>
                                        <th>
                                            <?php if ($row['exchange_status'] == 1) { ?>
                                                <button type="button" class="bgs" onclick="del(<?= $row['product_exchange_id']; ?>)"><img src="./src/images/icon-delete.png" width="25"></button>
                                                <a href="editproductexchange.php?id=<?= $row['product_exchange_id']; ?>" type="button" class="bgs"><img src="./src/images/icon-pencil.png" width="25"></a>
                                            <?php } ?>
                                        </th>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>';
                    } ?>
            </div>
        </div>
    </form>
</body>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/jquery-ui/dist/jquery-ui.min.js"></script>
<script src="./src/js/productexchangehistory.js"></script>

</html>