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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/budget.css" />

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
} else if (isset($_GET['firstdate']) && (isset($_GET['lastdate']))) {
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
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>งบการเงิน</h1>
                </div>
                <div class="row">
                    <div class="col">
                        <h5 class="tt">งบแสดงฐานะการเงิน</h5>
                        <div class="th"></div>
                        <div class="d-flex justify-content-end">
                            <button type="button" onclick="loadPDF()" class="g "><img src="./src/images/download.png " width="25">&nbsp;ดาวน์โหลด
                            </button>
                        </div>
                    </div>
                    <div class="row main q">
                        <div class="col-12 a">วันที่ขาย :
                            <input type="date" value="<?= $firstdate_text ?>" id="firstdate" name="firstdate" required>&nbsp
                            ถึง &nbsp<input type="date" value="<?= $lastdate_text ?>" id="lastdate" name="lastdate" required>
                            <button type="submit" class="s" id="search" name="search"><img src="./src/images/search.png" width="13"></button>
                        </div>
                        <div class="row f">
                            <div class="col-12">
                                <h4>สินทรัพย์</h4>
                            </div>
                        </div>
                        <div class="t">
                            <table class="table1">
                                <tr>
                                    <th width='10%'></th>
                                    <th width='50%'>รวม สินทรัพย์</th>
                                    <th width='25%' style="text-align: end;"><?= number_format($p['BG1']) ?></th>
                                    <th width='10%'>บาท</th>

                                </tr>
                                <tr>
                                    <th></th>
                                    <th>&nbsp&nbsp&nbsp&nbspสินค้าที่พร้อมขาย</th>
                                    <th style="text-align: end;"><?= number_format($p['BG1'] - ($b['BG2'])) ?></th>
                                    <th>บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>&nbsp&nbsp&nbsp&nbspเงินที่ได้รับแล้ว</th>
                                    <th style="text-align: end;"><?= number_format($b['cash2'] + $d['DB']) ?></th>
                                    <th>บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>&nbsp&nbsp&nbsp&nbspเงินที่ยังไม่ได้รับ</th>
                                    <th style="text-align: end;"><?= number_format(abs($b['credit2'] - $d['DB'])) ?></th>
                                    <th>บาท</th>
                                </tr>

                            </table>
                        </div>
                        <div class="row f">
                            <div class="col-12">
                                <h4 class="c">หนี้สิน+ทุน</h4>
                            </div>
                        </div>
                        <div class="t">
                            <table class="table1">
                                <tr>
                                    <th width='10%'></th>
                                    <th width='50%'>รวม หนี้สิน+ทุน</th>
                                    <th width='25%' style="text-align: end;"><?= number_format($c['BG3']) ?></th>
                                    <th width='10%'>บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>&nbsp&nbsp&nbsp&nbspทุน</th>
                                    <th width='25%' style="text-align: end;"><?= number_format($c['complete']) ?></th>
                                    <th>บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>&nbsp&nbsp&nbsp&nbspหนี้สิน(เงินสด)</th>
                                    <th width='25%' style="text-align: end;"><?= number_format($c['cash']) ?></th>
                                    <th>บาท</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>&nbsp&nbsp&nbsp&nbspหนี้สิน(เครดิต)</th>
                                    <th width='25%' style="text-align: end;"><?= number_format($c['credit']) ?></th>
                                    <th>บาท</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./src/js/budget.js"></script>
<script>
    function loadPDF() {
        if ($('#firstdate').val() && $('#firstdate').val() != "" && $('#lastdate').val() && $('#lastdate').val() != "") {
            var form = $('<form action="./service/PDF/template/budget.php" method="post">' +
                '<input type="hidden" name="BG1" value="<?= $p['BG1'] ?>" />' +
                '<input type="hidden" name="BG2" value="<?= $b['BG2'] ?>" />' +
                '<input type="hidden" name="BG3" value="<?= $c['BG3'] ?>" />' +
                '<input type="hidden" name="DB" value="<?= $d['DB'] ?>" />' +
                '<input type="hidden" name="firstdate" value="<?= $firstdate ?>" />' +
                '<input type="hidden" name="lastdate" value="<?= $lastdate ?>" />' +
                '<input type="hidden" name="credit" value="<?= $c['credit'] ?>" />' +
                '<input type="hidden" name="credit2" value="<?= $b['credit2'] ?>" />' +
                '<input type="hidden" name="cash" value="<?= $c['cash'] ?>" />' +
                '<input type="hidden" name="cash2" value="<?= $b['cash2'] ?>" />' +
                '<input type="hidden" name="complete" value="<?= $c['complete'] ?>" />' +
                '</form>'
            );
            $('body').append(form);
            $(form).submit();
        } else if ($('#firstdate').val() && $('#firstdate').val() == "" && $('#lastdate').val() && $('#lastdate').val() == "") {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'กรุณาเลือกวันที่',
                timer: 3000
            })
            return
        } else if ($('#firstdate').val() && $('#firstdate').val() == "" && $('#lastdate').val() && $('#lastdate').val() != "") {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'กรุณาเลือกช่วงแรกของวันที่',
                timer: 3000
            })
            return
        } else if ($('#firstdate').val() && $('#firstdate').val() != "" && $('#lastdate').val() && $('#lastdate').val() == "") {
            Swal.fire({
                icon: 'warning',
                title: 'คำเตือน',
                text: 'กรุณาเลือกช่วงสุดท้ายของวันที่',
                timer: 3000
            })
            return
        } 
    }
</script>

</html>