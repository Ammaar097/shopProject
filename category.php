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
    <link rel="stylesheet" href="./src/css/category.css" />
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css" />

</head>
<?php
include_once('nav.php');
include_once "./database/Category.php";
include_once "./database/Product.php";
$category =  new Category();
$rows = $category->fetchAll();
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col topic">
                    <h1>ประเภทสินค้า</h1>
                </div>
                <div class="row d-flex justify-content-end addproducttypebutton">
                    <div class="col-2">
                        <button class="submit btn" name="btCategory_click()" onclick="insert()"><img src="./src/images/plus.png" width="25">&nbsp เพิ่มประเภทสินค้า</button>
                    </div>
                </div>
            </div>
            <table class="col-11 tbproducttype">
                <thead>
                    <tr>
                        <th width=8%>ลำดับ</th>
                        <th width=54%>ประเภทสินค้า</th>
                        <th width=15%>รายการทั้งหมด</th>
                        <th width=15%>รายการที่ปิดการขาย</th>
                        <th width=8%><img src="./src/images/edit.png" width="25"></th>
                    </tr>
                </thead>
                <tbody id="categorytable">
                    <?php $i = 1;
                    foreach ($rows as $row) { ?>
                        <tr>
                            <th><?= $i ?></th>
                            <th id="text<?= $row['category_id'] ?>"><?= $row['category_name'] ?></th>
                            <th><?= number_format($category->getCount($row['category_id'], false)) ?></th>
                            <th><?= number_format($category->getCount($row['category_id'], true)) ?></th>
                            <th>
                                <button type="button" class="bgs" name="btDelete_click()" onclick="del(<?= $row['category_id'] ?>)"><img src="./src/images/icon-delete.png" width="25"></button>
                                <button type="button" class="bgs" name="btEdit_click()" onclick="edit(<?= $row['category_id'] ?>)"><img src="./src/images/icon-pencil.png" width="25"></button>
                            </th>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>





</body>

<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./src/js/category.js"></script>

</html>