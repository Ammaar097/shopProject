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
    <link rel="stylesheet" href="./src/css/manageuseraccounts.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>
<?php include_once('nav.php'); ?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-12">
                        <h1>จัดการดูแลบัญชีผู้ใช้งาน</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3 c">
                        <label for="account_user_type">ตำแหน่ง :</label>
                        <select name="account_user_type" id="account_user_type" style="background-color: #D4DDC6;">
                            <option value="position">บุคลากรทั้งหมด</option>
                            <option value="L">เจ้าของร้าน</option>
                            <option value="E">พนักงาน</option>
                        </select>
                    </div>
                    <div class="col-2 b">
                        <input type="text" id="keyword" class="btnd" placeholder="&nbsp ชื่อ-นามสกุล">
                        <button type="submit" class="s"><img src="./src/images/search.png" width="17">
                    </div>
                    <div class="col-2 a">
                        <a class="submit btn" href="adduseraccount.php"><img src="./src/images/plus.png" width="25">&nbsp เพิ่มบัญชีผู้ใช้งาน</a>
                    </div>
                </div>
                <div class="useraccountTable">
                    <h3 style="text-align: center; margin-top: 9rem;margin-bottom: 9rem;" id="no-let">ไม่พบข้อมูล</h3>
                    <table class="col-11 ma" id="tb-let">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>ตำแหน่ง</th>
                            <th>สถานะการใช้งาน</th>
                            <th><img src="./src/images/edit.png" width="25"></th>
                        </tr>
                        <tbody id='useraccountTable'></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ลบ -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title2" id="exampleModalLabel">ลบรายการ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>ยืนยันที่จะลบ</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary2">ตกลง</button>
                    </div>

                </div>
            </div>
        </div>

    </form>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./src/js/useraccount.js"></script>

</html>