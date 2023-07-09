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
    <link rel="stylesheet" href="./src/css/expiredproduct.css" />
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
                <div class="col-3">
                    <h1>สินค้าหมดอายุ</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-6 date">
                    <label for="expires within">หมดอายุภายใน :</label>
                    <label for="expires"></label>
                    <input type="date" value="<?= date('Y-m-d') ?>" name="date" id="date" name="expires" />
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
                <div class="col-2 search" style="margin-top: auto;">
                    <click type="submit" name="search" id="search" class="btn-c reset"><img src="./src/images/search.png" style="margin-left: 1.5rem;" width="25"></click>
                    <button type="button" onclick="reset()" class="btn-c1 reset" width="25">ล้างการค้นหา
                    </button>
                </div>
            </div>
            <div class="row tb">
                <h3 style="margin-top: 9rem; margin-bottom: 9rem; text-align: center" id="no-let">
                    ไม่มีรายการสินค้าใกล้หมดอายุ</h3>
                <table class="col-12" id="tb-let">
                    <thead>
                        <tr>
                            <th width="10%">รูปภาพ</th>
                            <th width="20%">ชื่อสินค้า</th>
                            <th width="15%">วันที่ได้รับของ</th>
                            <th width="15%">วันที่หมดอายุ</th>
                            <th width="15%">ราคา</th>
                            <th width="10%">คงคลัง</th>
                            <th width="10%">จำนวน</th>
                            <th width="5%"><img src="./src/images/edit.png" width="25"></th>
                        </tr>
                    </thead>
                    <tbody id="expireTable"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="./src/js/expiredproduct.js"></script>
<script src="./src/js/datetimeDisplay.js"></script>
<script>
    function convertToDateThai(date) {
        var month_th = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return result = date.getDate() + " " + month_th[(date.getMonth() + 1)] + " " + (date.getFullYear() + 543);
    }

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