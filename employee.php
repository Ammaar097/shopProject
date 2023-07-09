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
    <link rel="stylesheet" href="./src/css/employee.css" />
    <link href="./node_modules/sweetalert2/dist/sweetalert2.css" rel="stylesheet"></link>

</head>
<?php
include_once('nav.php');
include_once('database/Employee.php');
$employee = new Employee();
if (isset($_GET['keyword'])) {
    $rows = $employee->searchByName($_GET['keyword']);
} else {
    $rows = $employee->fetchAll();
}
?>

<body>
<form>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col-11">
                    <h1>พนักงาน</h1>
                </div>
            </div>
            <form action="employee.php" method="GET">
                <div class="row d-flex justify-content-end" style="margin-right: 1rem;">
                    <div class="col-3 d-flex justify-content-end" style="margin-right: 2rem;">
                        <input type="text" name="keyword" class="btn-d" placeholder="&nbsp ชื่อ-นามสกุล">
                        <button type="submit" class="s">
                            <img src="./src/images/search.png" width="20">
                        </button>
                    </div>
                    <div class="col-2">
                        <a class="submit btn" href="addnewstaff.php"><img class='add' src="./src/images/plus.png" width="25">&nbsp เพิ่มพนักงาน</a>
                    </div>
            </form>
        </div>
        <?php if (count($rows) > 0) { ?>
            <table class="ma">
                <tr>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th class="copy">สำเนาบัตรประชาชน</th>
                    <th class="copy">สำเนาทะเบียนบ้าน</th>
                    <th>สถานะการใช้งาน</th>
                    <th><img src="./src/images/edit.png" width="25"></th>
                </tr>
                <?php foreach ($rows as $e) { ?>
                    <tr>
                        <th style="text-align: left;">&nbsp<?= $e['employee_firstname'] . " " . $e['employee_lastname']; ?></th>
                        <th><?= $e['employee_card_id']; ?></th>
                        <th><?= $e['employee_telephone']; ?></th>
                        <th><a href="<?= $e['employee_card_id_copy']; ?>">ดู</a></th>
                        <th><a href="<?= $e['employee_address_copy']; ?>">ดู</a></th>
                        <th>
                            <label class="switch">
                                <input type="checkbox" id="S<?= $e['employee_id']; ?>" <?= $e['employee_status'] == 1 ? "checked" : ""; ?> onchange="setStatus(<?= $e['employee_id']; ?>)" />
                                <span class="slider round"></span>
                            </label>
                        </th>
                        <th>
                            <button type="button" class="bgs" onclick="del(<?=$e['employee_id']; ?>)" ><img src="./src/images/icon-delete.png" width="25"></button>
                            <a type="button" class="btn1" href="editstaff.php?id=<?= $e['employee_id']; ?>"><img src="./src/images/icon-pencil.png" width="25"></a>
                        </th>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {
            echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>';
        } ?>
    </div>
    </div>
</form>
</body>
<script src="./node_modules/sweetalert2/dist/sweetalert2.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./src/js/employee.js"></script>
</html>