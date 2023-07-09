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
    <link rel="stylesheet" href="./src/css/salehistory.css"/>

</head>
<?php
include_once('nav.php');
include_once './database/Sales.php';
include_once './service/datetimeDisplay.php';
$sales = new Sales();
$firstdate_text = date('Y-m-d');
$lastdate_text = date('Y-m-d');
if (isset($_GET['start']) && isset($_GET['end']) && $_GET['start'] != '' && $_GET['end'] != '') {
    $rows = $sales->fetchBetween($_GET['start'], $_GET['end']);
    $rowc = $sales->fetchBetween2($_GET['start'], $_GET['end']);
    $all = [];
    foreach ($rows as $s){
        if ($s['payment_sl'] != "ผ่อนชำระ"){
            $all[]=$s;
        }
    }
    foreach ($rowc as $c){
        $all[]=$c;
    }
} else if ((!isset($_GET['start']) && !isset($_GET['end'])) || ($_GET['start'] != '' && $_GET['end'] != '')) {
    $rows = $sales->fetchAllContract();
    $rowc = $sales->fetchAllContract2();
    $all = [];
    foreach ($rows as $s){
        if ($s['payment_sl'] != "ผ่อนชำระ"){
            $all[]=$s;
        }
    }
    foreach ($rowc as $c){
        $all[]=$c;
    }
}
$r = -1;
while ($r != 0) {
    $r = 0;
    for ($i = 0; $i < count($all); $i++) {
        if($i+1<count($all)){
            $low = $all[$i];
            $up = $all[$i+1];
            if($low['sales_list_id']<$up['sales_list_id']){
                $all[$i+1] = $low;
                $all[$i] = $up;
                $r++;
            }
        }
    }
}
?>

<body>
<div class="row">
    <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
    <div class="col-11">
        <div class="row main">
            <div class="col-6">
                <h1>ประวัติการขาย</h1>
            </div>
        </div>
        <form action="salehistory.php" method="get">
            <div class="row d-flex justify-content-end" style="margin-right: 2rem;">
                <div class="col-4">
                    <input value="<?= $firstdate_text ?>" value="<?= isset($_GET['start']) ? $_GET['start'] : '' ?>"
                           class="dateS" type="date" name="start" id="firstdate">
                    ถึง&nbsp&nbsp
                    <input value="<?= $lastdate_text ?>" value="<?= isset($_GET['end']) ? $_GET['end'] : '' ?>"
                           class="star" type="date" name="end">
                    <button type="submit" class="s"><img src="./src/images/search.png" width="20"></button>
                </div>
                <div class="col-2">
                    <button type="button" onclick="window.location= 'salehistory.php'" class="btn-c reset">
                        ล้างข้อมูลการค้นหา
                    </button>
                </div>
            </div>
        </form>
        <?php if (count($all) > 0) { ?>
            <table class="col-11 saletable">
                <tr>
                    <th width=20%>วันที่</th>
                    <th width=20%>เวลาที่ขาย</th>
                    <th width=15%>เลขที่ใบเสร็จ/ใบส่งของ</th>
                    <th width=15%>จำนวนรวม</th>
                    <th width=15%>ยอดรวมทั้งหมด</th>
                    <th width=25%>ช่องทางการชำระ</th>
                </tr>
                <tbody id="salesHistory">
                <?php foreach ($all as $row){ if (!isset($row['outstanding'])||!($row['outstanding'] > 0)) { ?>
                    <tr>
                        <th><?= dateTimeDisplay($row['payment_dt']) ?></th>
                        <th><?= ShowTime($row['payment_dt']) ?></th>
                        <th>
                            <a href="<?= $row['payment_sl'] != 'ผ่อนชำระ' ? './service/PDF/template/receipt.php?id=' . $row['sales_list_id'] : './service/PDF/template/invoice2.php?id=' . $row['sales_list_id'] ?>"><img src="./src/images/print.png" class="g" width="25"></a></th>
                        <th><?= number_format($row['all_quantity']) ?></th>
                        <th><?= number_format($row['all_price']) ?></th>
                        <th><?php if ($row['payment_sl'] == 'โอนผ่านบัญชีธนาคาร') { ?><a type="button" class="bgs" href="./bankslip.php?id=<?= $row['sales_list_id']; ?>">
                                    <font color=#A36627 style="text-decoration: none;"><?= $row['payment_sl'] ?></font>
                                </a>
                            <?php } else { ?>
                                <?= $row['payment_sl'] ?>
                            <?php } ?></th>
                    </tr>
                <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        <?php } else {
            echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>';
        } ?>
    </div>
</div>
<!--<a href="<?= $row['payment_sl'] != 'ผ่อนชำระ' ? './service/PDF/template/receipt.php?id=' . $row['sales_list_id'] : './service/PDF/template/invoice2.php?id=' . $row['sales_list_id'] ?>">-->
</form>
</body>
<script src="./src/js/sales.js"></script>

</html>