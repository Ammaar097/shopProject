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
    <link rel="stylesheet" href="./src/css/dailybestseller.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>
<?php
include_once('nav.php');
include_once "./database/Category.php";
include_once "./database/Product.php";
$product = new Product();
$p = $product->fetchAll();
$category = new Category();
$c = $category->fetchAll();
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col-6">
                    <h1>สินค้าขายดีประจำวัน</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-end" style="margin-right: 3rem; margin-top: 1rem">
                <div class="col-4 date">
                    <label for="expires"></label>
                    <input type="date" style="height: 100%" value="<?= date('Y-m-d') ?>" name="date" id="date" name="expires" />
                </div>
                <div class="col-3 category">
                    <form>
                        <select name="category_id" id="category_id" style="background-color: #D4DDC6;  margin-right: 1rem;" required>
                            <option value="all">สินค้าทั้งหมด</option>
                            <?php foreach ($c as $row) { ?>
                                <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" id="keyword" name="keyword" class="btn-d" placeholder="&nbsp ชื่อสินค้า">
                    </form>
                </div>
                <div class="col-3" style="margin-top: 0.15rem;">
                    <click type="submit" name="search" id="search" class="btn-c reset"><img src="./src/images/search.png" style="margin-left: 1.4rem; " width="25"></click>
                    <button type="button" onclick="reset()" class="btn-c1 reset" style="margin-left: 1.4rem; " width="25">ล้างการค้นหา</button>
                </div>
            </div>
            <div class="dailybestsellerTable">
                <h3 style="text-align: center; margin-top: 9rem;margin-bottom: 9rem;" id="no-let">ไม่มีรายการสินค้าขายดีประจำวัน</h3>
                <table class="col-11" id="tb-let" style="display: none;">
                    <thead>
                        <tr>
                            <th width="10%">ลำดับ</th>
                            <th width="20%">รูปภาพ</th>
                            <th width="25%">ชื่อสินค้า</th>
                            <th width="20%">ราคา</th>
                            <th width="15%">คงเหลือ</th>
                            <th width="10%">จำนวนที่ขาย</th>
                        </tr>
                    <tbody id="dailybestsellerTable"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="./src/js/dailybestseller.js"></script>
<script>
    var input1 = document.getElementById("date");
    input1.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
    var input2 = document.getElementById("category_id");
    input2.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
    var input3 = document.getElementById("keyword");
    input3.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
</script>

</html>