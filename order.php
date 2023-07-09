<?php
include_once('service/auth.php');
include_once('service/dateFormat.php');
include_once "./service/datetimeDisplay.php";
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
    <link rel="stylesheet" href="./src/css/order.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>
<?php
include_once('nav.php');
include_once('./database/Order.php');
$order = new Order();
if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
    $rows = $order->search($_GET['keyword']);
} else {
    $rows = $order->fetchAllSell();
}
?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>รายการใบสั่งซื้อ</h1>
                    <div class="d-flex justify-content-end" style="margin-left: -5rem">
                        <div>
                            <input type="text" value="<?= $_GET['keyword'] ?? "" ?>" id="keyword" name="keyword" class="btnd" placeholder="&nbsp ชื่อผู้ขาย">
                            <button type="submit" class="search"><img src="./src/images/search.png" width="20"></button>
                        </div>
                        <a class="submit btn" href="addorder.php"><img src="./src/images/plus.png" width="25">&nbsp;&nbsp;เพิ่มใบสั่งซื้อ&nbsp;&nbsp;</a>
                    </div>
                </div>
                <?php if (count($rows) > 0) { ?>
                    <table class="ordertable">
                        <tr>
                            <th width="20%">วันที่สั่งซื้อ</th>
                            <th width="30%">ชื่อผู้ขาย</th>
                            <th width="15%">สถานะการสั่งซื้อ</th>
                            <th width=10%>พิมพ์</th>
                            <th width="10%"><img src="./src/images/edit.png" width="25"></th>
                        </tr>
                        <?php foreach ($rows as $row) { ?>
                            <tr>
                                <th><?= dateTimeDisplay($row['datebill']) ?></th>
                                <th id="text<?= $row['sell_id'] ?>"><?= $row['sell_name'] ?></th>
                                <th>
                                    <?php if ($row['order_status'] == 1) { ?><a type="button" class="bgs" href="./editconfirm2.php?id=<?= $row['order_id']; ?>">
                                            <font color=#A36627 style="text-decoration: none;">รอของ</font>
                                        </a>
                                    <?php } else { ?>
                                        สำเร็จ
                                    <?php } ?>
                                </th>
                                <th>
                                    <a type="button" class="bgs" href="./service/PDF/template/order_cash.php?id=<?= $row['order_id']; ?>"><img src="./src/images/print.png" width="25"></a>
                                </th>
                                <th>
                                    <?php if ($row['order_status'] == 1) { ?>
                                        <button type="button" class="bgs" name="btDelete_click()" onclick="del(<?= $row['order_id'] ?>)"><img src="./src/images/icon-delete.png" width="25"></button>
                                        <a type="button" class="bgs" href="./editconfirm.php?id=<?= $row['order_id']; ?>"><img src="./src/images/icon-pencil.png" width="25"></a>
                                    <?php } ?>
                                </th>
                                </th>
                            </tr><?php } ?>
                    </table>
                <?php } else {
                    echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>';
                } ?>
            </div>
        </div>
        </div>
    </form>
</body>

<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./src/js/order.js"></script>

</html>