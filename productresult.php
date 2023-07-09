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
    <script src=" ./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./src/css/productresult.css" />


</head>

<?php include_once('nav.php');
include_once "./database/Category.php";
$category = new Category();
$rows = $category->fetchAll();

?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-12" style="<?= getRole() == 'L' ? '':'margin-left :-2rem;' ?>">
                        <h1 style="<?= getRole() == 'L' ? '':'margin-left :2rem;' ?>">รายการสินค้าทั้งหมด</h1>
                        <div class="row d-flex justify-content-end" >
                            <div class="col-2 d-flex justify-content-end" >
                                <select name="category_id" id="category_id" class="g"  required>
                                    <option value="all" selected>&nbsp;&nbsp;&nbsp;สินค้าทั้งหมด</option>
                                    <?php foreach ($rows as $row) { ?>
                                        <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-4 d-flex justify-content-center" style="margin-left: -2rem; margin-right: -2rem;">
                                <input name="keyword" id="keyword" type="text" class="btnd" placeholder="&nbsp&nbsp&nbsp&nbsp&nbspพิมพ์ชื่อสินค้าเพื่อค้นหาโดยอัตโนมัติ">
                            </div>
                            <?php if (getRole() == 'L') { ?>
                                <div class="col-2 d-flex justify-content-start">
                                    <a type="button" href="./addproduct.php" class="submit btn"><img src="./src/images/plus.png" width="25">&nbsp เพิ่มสินค้า</a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?= (getRole())?>" id="H">
                <table class="col-11 producttable">
                    <thead>
                        <tr>
                            <th width="11%">ประเภท</th>
                            <th width="20%">ชื่อสินค้า</th>
                            <th width="8%">ยี่ห้อ</th>
                            <th width="8%">รุ่น</th>
                            <th width="8%">จำนวน</th>
                            <th width="8%">คงเหลือ</th>
                            <th width="9%">ราคา</th>
                            <th width="14%">รูปภาพ</th>
                            <?php if (getRole() == 'L') { ?>
                            <th width="7%">การขาย</th>
                            <th width="7%"><img src="./src/images/edit.png" width="25"></th>
                            <?php } ?>
                        </tr>
                    <tbody id="productResultTable"></tbody>
                </table>
            </div>
        </div>
    </form>
</body>
<script src="./node_modules/sweetalert2/dist/sweetalert2.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./src/js/productresult.js"></script>

</html>