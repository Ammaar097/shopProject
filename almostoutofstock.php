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
    <link rel="stylesheet" href="./src/css/almostoutofstock.css" />

</head>
<?php include_once('nav.php'); ?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col">
                    <h1>สินค้าใกล้หมด</h1>
                </div>
            </div>
            <div class="row ma">
                <div class="col-5">
                    <label for="category"></label>
                    <select name="category" id="category">
                        <option value="category" selected>เลือกประเภทสินค้า</option>
                    </select>
                </div>
                <div class="col-4">
                    <form>
                        <input type="text" class="btn-d" placeholder="&nbsp ชื่อสินค้า">
                        <button type="submit" class="s">
                            <img src="./src/images/search.png" width="15">
                        </button>
                    </form>
                </div>
            </div>
            <div class="row n">
                <div class="col-10">ใบตัดหญ้า</div>
                <div class="col-2">จำนวน 1 รายการ</div>
            </div>
            <table class="mai">
                <tr>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>สถานะการขาย</th>
                </tr>
                <tr>
                    <th><img src="./src/images/lawnmower.png" width="100"></th>
                    <th>ใบตัดหญ้า มีฟัน(แบบวงเดือน) รุ่น 10X24T</th>
                    <th>105/ใบ</th>
                    <th>2</th>
                    <th>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </th>
                </tr>
                <tr>
                    <th><img src="./src/images/smalltriangularlleaves.png" width="100"></th>
                    <th>ใบสามเหลี่ยมเล็ก</th>
                    <th>20/ใบ</th>
                    <th>0</th>
                    <th>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</body>