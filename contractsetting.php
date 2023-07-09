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
    <link rel="stylesheet" href="./src/css/contractsetting.css" />

</head>
<?php
include_once('nav.php');
include_once('database/Employee.php');
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['interest'])) {
    $_SESSION['interest'] = 2;
}
if (!isset($_SESSION['interest_month'])) {
    $_SESSION['interest_month'] = 4;
}
if (isset($_POST['interest_month']) && isset($_POST['interest'])) {
    $_SESSION['interest_month'] = $_POST['interest_month'];
    $_SESSION['interest'] = $_POST['interest'];
}
$employee = new Employee();
$labers = $employee->fetchLabers();
?>

<body>
    <form action="contractsetting.php" method="post" id="form1" name="form1">
        <input type="hidden" id="employee_id" name="employee_id" value="<?= $_SESSION['employee_id'] ?>">
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>ตั้งค่าสัญญาซื้อขาย</h1>
                    <p></p>
                    <p></p>
                    <div class="col-12">
                        <h4>นามผู้ขาย</h4><br>
                        <table class="col-5 mm">
                            <tr>
                                <th>ชื่อ-นามสกุล</th>
                                <th>สถานะการใช้งาน</th>
                            </tr>
                            <?php foreach ($labers as $laber) { ?>
                                <tr>
                                    <th><?= $laber['employee_prefix']; ?><?= $laber['employee_firstname']; ?> <?= $laber['employee_lastname']; ?></th>
                                    <th><label class="switch">
                                            <input type="checkbox" id="S<?= $laber['employee_id']; ?>" <?= $laber['employee_status'] == 1 ? "checked" : "" ?> onchange="setStatus(<?= $laber['employee_id']; ?>)">
                                            <span class="slider round"></span>
                                        </label>
                                    </th>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="row mai">
                    <h4>ตั้งค่าการคิดดอกเบี้ย</h4>
                </div>
                <div class="row mmm">
                    <div class="col-6">เริ่มคิดดอกเบี้ยเดือนที่ : &nbsp &nbsp
                        <select name="interest_month" style="background-color: #D4DDC6;">
                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <option value="<?= $i ?>" <?= $i == $_SESSION['interest_month'] ? 'selected' : '' ?>><?= $i ?></option>
                            <?php } ?>
                        </select>&nbsp &nbspนับจากวันที่ลูกค้าซื้อสินค้า
                    </div>
                    <p></p>
                    <div class="col-6">
                        ดอกเบี้ยต่อเดือน : &nbsp &nbsp
                        <input type="text" value="<?= $_SESSION['interest'] ?>" name="interest" id="interest" style="width: 8%; text-align: right;">&nbsp;%
                    </div>
                    <p></p>
                    <div class="col-6">
                        ดอกเบี้ยสูงสุดต่อปี :&nbsp;&nbsp;&nbsp;<?= ($_SESSION['interest'] * (12 - $_SESSION['interest_month']) - 1) ?>&nbsp;&nbsp;%
                        <input type="hidden" value="<?= ($_SESSION['interest'] * (12 - $_SESSION['interest_month']) - 1) ?>" name="interest_year" id="interest_year" readonly> ตามกฎหมาย
                    </div>
                </div>
                <div class="row btn-g">
                    <div class="col-2">
                        <button type="button" class="btn-c reset" onclick="javascript:window.location='index.php';">ยกเลิก</button>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn-c submit" onclick="Submit()" value="บันทึก">บันทึก</button>
                    </div>
                </div>
            </div>

    </form>
</body>
<script src="./src/js/contractsetting.js"></script>

</html>