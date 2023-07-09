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
    <link rel="stylesheet" href="./src/css/vat.css" />
    
</head>
<?php
if (!isset($_SESSION)) {
    session_start();
};
if (!isset($_SESSION['vat'])) {
    $_SESSION['vat'] = 7;
}
if (isset($_POST['vat'])) {
    $_SESSION['vat'] = $_POST['vat'];
}
include_once('nav.php'); ?>

<body>
    <form method="post" action="vat.php" id="form1" name="form1">
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>ตั้งค่าภาษีมูลค่าเพิ่ม</h1>
                    <table class="main col-10">
                        <tr>
                            <th>ภาษีมูลค่าเพิ่ม &nbsp<input type="text" name="vat" id="vat" value="<?= $_SESSION['vat']; ?> " style="width: 3%; text-align: right;"> &nbsp %</th>
                        </tr>
                    </table>
                    <div class="row btn-g">
                        <div class="col-2">
                            <!--<button type="reset" class="btn-c reset">ยกเลิก</button>-->
                        </div>
                        <div class="col-2">
                        <button type="button" class="btn-c submit" onclick="Submit()" value="บันทึก">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./src/js/vat.js"></script>
</html>