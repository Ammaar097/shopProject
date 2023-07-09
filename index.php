<?php
include_once('service/auth.php');
isLogin();
if (!isset($_SESSION)) {
    session_start();
}
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

if (!isset($_SESSION['shop_name'])) {
    $_SESSION['shop_name'] = "วรเชษฐ์เกษตรภัณฑ์";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/aa.css" />
    
</head>
<?php
include_once('nav.php');
include_once('./database/Budget.php');
$budget = new Budget();
$firstdate = date('d/m/Y');
$lastdate = date('d/m/Y');
$firstdate_text = date('Y-m-d');
$lastdate_text = date('Y-m-d');
if (!isset($_GET['firstdate']) && (!isset($_GET['lastdate']))) {
    $budget = new Budget();
    $b = (array)$budget->fetchBetweenSales2();
    $c = (array)$budget->fetchBetweenOrder2();
    $p = (array)$budget->fetchBetweenProduct();
    $d = (array)$budget->fetchBetweenDebt2();

}
else if (isset($_GET['firstdate']) && (isset($_GET['lastdate']))) {
    $firstdate = $_GET['firstdate'];
    $lastdate = $_GET['lastdate'];
    $firstdate_text = $_GET['firstdate'];
    $lastdate_text = $_GET['lastdate'];
    $b = (array)$budget->fetchBetweenSales($firstdate, $lastdate);
    $c = (array)$budget->fetchBetweenOrder($firstdate, $lastdate);
    $p = (array)$budget->fetchBetweenProduct();
    $d = (array)$budget->fetchBetweenDebt($firstdate, $lastdate);
}
?>

<body>
<form method="get" action="index.php" name="index" id="index">
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col-6">
                    <h1><?=$_SESSION['shop_name']?></h1>
                </div>
            </div>
            <div class="row mai">
                <div class="col-5">
                    <h3>ยินดีต้อนรับ</h3>
                    <?php if (getRole() == 'E' || getRole() == 'L') { ?>
                    <div class="line"></div>
                    <div class="col-4">
                        <button type="button" class="button" onclick="javascript:window.location='dailybestseller.php';">&nbsp
                            สินค้าขายดี &nbsp
                        </button>
                    </div>
                    <div class="col-4">
                        <button type="button" class="button" onclick="javascript:window.location='expiredproduct.php';">&nbsp
                            สินค้าหมดอายุ &nbsp&nbsp
                        </button>
                    </div>
                    <?php if (getRole() == 'L') { ?>
                        <div class="col-4">
                            <button type="button" class="button" onclick="javascript:window.location='searchstatistics.php'" ;>&nbsp
                                สถิติการค้นหา &nbsp
                            </button>
                        </div>
                        <div class="col-7">
                            <button type="button" class="button" onclick="javascript:window.location='productsearchstatistics.php';">&nbsp
                                สถิติการค้นหาโดยประเภทสินค้า &nbsp
                            </button>
                        </div><?php } ?>
                </div>
                <div class="col-6 scoreboard">
                    <div class="textboard">
                        <label class="result">ข้อมูลสรุป&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</label>
                        <input type="date" value="<?= $firstdate_text ?>" id="firstdate" name="firstdate" required>&nbsp
                        ถึง &nbsp<input type="date" value="<?= $lastdate_text ?>" id="lastdate" name="lastdate" required>
                        <button type="submit" class="search" id="search" name="search"><img src="./src/images/search.png" width="13"></button>
                    </div>
                    <div class="board">
                        <table >
                                <tr>
                                    <th width='10%'></th>
                                    <th width='50%'>ยอดขาย : </th>
                                    <th width='25%' style="text-align: end;"><?= number_format($b['cash2'] + $d['DB']) ?></th>
                                    <th width='10%'>&nbsp;&nbsp;บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>ต้นทุนขาย + ค่าใช้จ่าย : </th>
                                    <th width='25%' style="text-align: end;"><?= number_format($c['BG3']) ?></th>
                                    <th>&nbsp;&nbsp;บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>กำไรสุทธิ : </th>
                                    <th width='25%' style="text-align: end;"><?= number_format(($b['cash2'] + $d['DB'])-$c['BG3']) ?></th>
                                    <th>&nbsp;&nbsp;บาท</th>
                                </tr>
                            </table>
                    </div>
                </div>

            </div>
            <?php } ?>
        </div>
    </div>
</form>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script>
    function loadPDF() {
        if ($('#firstdate').val() && $('#firstdate').val() != "" && $('#lastdate').val() && $('#lastdate').val() != "") {
            var form = $('<form action="./service/PDF/template/budget.php" method="post">' +
                '<input type="hidden" name="BG1" value="<?=$p['BG1']?>" />' +
                '<input type="hidden" name="BG2" value="<?=$b['BG2']?>" />' +
                '<input type="hidden" name="BG3" value="<?=$c['BG3']?>" />' +
                '<input type="hidden" name="firstdate" value="<?=$firstdate?>" />' +
                '<input type="hidden" name="lastdate" value="<?=$lastdate?>" />' +
                '<input type="hidden" name="credit" value="<?=$c['credit']?>" />' +
                '<input type="hidden" name="cash" value="<?=$c['cash']?>" />' +
                '<input type="hidden" name="complete" value="<?=$c['complete']?>" />'+
            '</form>'
        )
            ;
            $('body').append(form);
            $(form).submit();
        }
    }
    function out(){
        location.reload("./repay.php")
    }

</script>

</html>