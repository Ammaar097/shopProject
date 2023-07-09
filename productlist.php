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
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
    </link>
    <link rel="stylesheet" href="./src/css/productlist.css" />



</head>
<?php include_once('nav.php');
include_once('database/product.php');
include_once "./database/Category.php";
$category =  new Category();
$product = new Product();
$lost = $product->fetchLost();
$rows = $category->fetchAll();
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main d-flex justify-content-start topic">
                <div class="col-5">
                    <h1>รายการสินค้า</h1>
                </div>
                <div class="col-3 u">
                    <input name="keyword" id="keyword" type="text" class="btnd" placeholder="&nbsp&nbsp&nbsp&nbsp&nbspพิมพ์ชื่อสินค้าเพื่อค้นหาโดยอัตโนมัติ">
                </div>
                <div class="col-2 m">
                    <select name="category_id" id="category_id" class="n" required>
                        <option value="all">&nbsp&nbsp&nbsp&nbsp&nbspสินค้าทั้งหมด</option>
                        <?php foreach ($rows as $row) { ?>
                            <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-1 a">
                    <a href="./addtocart.php"><img src="./src/images/cart.png" width="60" /><span id="show" class="bell" style="width: 18pt; height: 18pt; font-size: 10pt;"></span></a>
                </div>
            </div>
            <table class="col-11 q" style="border: 0px">
                <thead>
                    <tr>
                        <th colspan="6" style="border: 0px">
                            <div class="topic_all" style="background-color: #ABBE99">
                                <h5 class="z">รายการสินค้าทั้งหมด</h5>
                            </div>
                        </th>

                    </tr>
                </thead>
                <tbody id="productlistTable"></tbody>
            </table>
        </div>
    </div>

</body>

<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src=" ./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./src/js/productlist.js"></script>
<script>
    function convertToDateThai(date) {
        var month_th = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return result = date.getDate() + " " + month_th[(date.getMonth() + 1)] + " " + (date.getFullYear() + 543);
    }
</script>

</html>