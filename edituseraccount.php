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
    <link rel="stylesheet" href="./src/css/edituseraccount.css" />

</head>

<?php
include_once('nav.php');
include_once('database/UserAccount.php');
$useraccount = new UserAccount();
$rows = $useraccount->fetchByIdWithoutAdmin($_GET['id']);
?>

<body>
    <form action="controller/UserAccount.php" name="form1" id="form1" method="POST">
        <input type="hidden" value="useraccount" name="table" />
        <input type="hidden" value="update" name="form_action" />
        <input type="hidden" value="<?= $_GET['id'] ?>" name="unique_id" />
        <input type="hidden" value="<?= $rows['employee_id'] ?>" name="employee_id" />
        <div class="row main">
            <div class="row">
                <h1>แก้ไขบัญชีผู้ใช้งาน</h1>
            </div>
            <div class="row top">
                <div class="col leftposition">
                    <label for="account_user_type">ตำแหน่ง : </label>
                    <input type="radio" name="account_user_type" value="L" class="bb" <?= $rows['account_user_type'] == 'L' ? 'checked' : '' ?>>
                    <label for="account_user_type">เจ้าของร้าน </label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="account_user_type" value="E" <?= $rows['account_user_type'] == 'E' ? 'checked' : '' ?>>
                    <label for="account_user_type">พนักงาน</label>
                    <div class="j">*</div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-lg-3 login leftemail">
                    <label for="email">อีเมล :</label>
                    <input name="account_username" id="account_username" type="email" onblur='check_email(this)' class="bb" value="<?= $rows['account_username']; ?>" required />
                    <div class="d">*</div>
                </div>
                <div class="col-lg-4 login leftpassword">
                    <label for="password">รหัสผ่าน :</label>
                    <input name="account_password" id="account_password" type="password" class="bb" autocomplete="new-password" />
                    <div class="e">*</div>
                </div>
            </div>
            <div class="row btn-g">
                <div class="col-lg-2 col-md-4">
                    <button type="reset" class="btn-c reset" onclick="javascript:window.location='manageuseraccounts.php';">ยกเลิก</button>
                </div>
                <div class="col-lg-10 col-md-4">
                    <input type="submit" class="btn-c submit" value="บันทึก" />
                </div>
            </div>
    </form>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules//sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./src/js/edituseraccount.js"></script>

</html>