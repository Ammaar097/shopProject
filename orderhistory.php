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
    <link rel="stylesheet" href="./src/css/orderhistory.css" />

</head>
<?php
include_once('nav.php');
include_once('./controller/OrderKeyword.php');
$rows = getdata();
?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>ประวัติใบสั่งซื้อ</h1>
                    <div class="d-flex justify-content-end" style="margin-left:-4.1rem">
                        <input type="date" value="<?= $_GET['date'] ?? "" ?>" name="date" id="date" class="date" />&nbsp&nbsp&nbsp
                        <div class="d-flex justify-content-end" style="margin-left: -2rem">
                            <input type="text" value="<?= $_GET['keyword'] ?? "" ?>" name="keyword" id="keyword" class="btnd" placeholder="&nbsp ชื่อผู้ขาย">
                            <button type="submit" class="search sh"><img src="./src/images/search.png" width="20"></button>
                            <button type="button" onclick="window.location= 'orderhistory.php'" class="btn-c reset">
                                ล้างข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
                <?php if (count($rows) <= 0) {
                    echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>'; ?>
                <?php } else { ?>
                    <table class="ordertable">
                        <tr>
                            <th width="20%">วันที่ชำระ</th>
                            <th width="60%">ชื่อผู้ขาย</th>
                            <th width="15%">สถานะ</th>
                        </tr>
                        <?php $i = 1;
                        foreach ($rows as $row) { ?>
                            <tr id="<?= $i ?>">
                                <th><?= dateTimeDisplay($row['payment_dt']) ?></th>
                                <th id="text<?= $row['sell_id'] ?>"><?= $row['sell_name'] ?></th>
                                <th>สำเร็จ</th>
                            </tr>
                        <?php }
                        $i++; ?>
                    </table>
                <?php } ?>
            </div>
        </div>
        </div>
    </form>
</body>

<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</html>