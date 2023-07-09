<?php
include_once('service/auth.php');
isAdmin();
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
    <link rel="stylesheet" href="./src/css/adduseraccount.css" />

</head>
<?php
include_once('nav.php');
include_once('database/Employee.php');
$employee = new Employee();
$rows = $employee->fetchWithOutUserId();
?>

<body>
    <form action="controller/UserAccount.php" name="form1" id="form1" method="POST">
        <input type="hidden" value="useraccount" name="table" />
        <input type="hidden" value="insert" name="form_action" />
        <!-- หัวข้อหลัก -->
        <div class="row main">
            <div class="row">
                <h1>เพิ่มบัญชีผู้ใช้งาน</h1>
            </div>
            <!--เนื้อหา-->
            <div class="row top">
                <div class="col-lg-4 col-md-12 employee">
                    <label for="employee_id">ชื่อพนักงาน :</label>
                    <select name="employee_id" id="employee_id" class="bb" required onchange="readEmail()" style="background-color: #D4DDC6;">
                        <option value="" selected hidden>เลือกพนักงาน</option>
                        <?php foreach ($rows as $row) { ?>
                            <option value="<?= $row['employee_id'] ?>"><?= $row['employee_prefix'] ?> <?= $row['employee_firstname'] ?> <?= $row['employee_lastname'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="a">*</div>
                </div>
                <div class="col leftposition">
                    <label for="account_user_type">ตำแหน่ง :</label>
                    <input type="radio" name="account_user_type" value="L" class="bb" checked>
                    <label for="account_user_type">เจ้าของร้าน </label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="account_user_type" value="E">
                    <label for="account_user_type">พนักงาน</label>
                    <div class="j">*</div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 login leftemail">
                    <label for="email">อีเมล :</label>
                    <input name="account_username" value="" id="account_username" type="email" class="bb" required />
                    <div class="d">*</div>
                </div>
                <div class="col-lg-4 login leftpassword">
                    <label for="password">รหัสผ่าน :</label>
                    <input name="account_password" id="account_password" type="password" onblur='check_num(this)' class="bb" required />
                    <div class="e">*</div>
                </div>
            </div>
            <div class="col-lg-4 leftstatus">
                <label for="status">สถานะการใช้งาน :</label>
                <label class="switch bb">
                    <input type="checkbox" id="account_user_status" name="account_user_status">
                    <span class="slider round" id="account_user_status" name="account_user_status"></span>
                </label>
                <div class="h">*</div>
            </div>

            <!--ปุ่มบันทึกและปุ่มยกเลิก-->
            <div class="row btn-g">
                <div class="col-lg-2 col-md-12">
                    <button type="button" class="btn-c reset" onclick="javascript:window.location='manageuseraccounts.php';">ยกเลิก</button>
                </div>
                <div class="col-lg-10 col-md-12">
                    <input type="submit" class="btn-c submit" value="บันทึก" />
                </div>
            </div>
    </form>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules//sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./src/js/adduseraccount.js"></script>

</html>