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
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./src/css/editproduct.css" />


</head>
<?php
include_once('nav.php');
include_once('database/Product.php');
include_once('database/Category.php');
include_once "./database/Sell.php";
include_once('database/CostPrice.php');
include_once('controller/Redirection.php');
$product = new Product();
$category = new Category();
$sell = new Sell();
$costprice = new CostPrice();
if (!isset($_GET['id'])) {
    redirection('/productresult.php');
}
$p = $product->fetchById($_GET['id']);
$rows = $product->fetchcate($_GET['id']);
$sells = $product->fetchsell($_GET['id']);
$c = $costprice->fetchById($_GET['id']);
//เริ่มทำแก้ไข//
?>

<body>
    <form action="controller/Product.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_img" value="<?= $p['product_img']; ?>" />
        <input type="hidden" name="product_detail_img" value="<?= $p['product_detail_img']; ?>" />
        <input type="hidden" value="product" name="table" />
        <input type="hidden" value="update" name="form_action" />
        <input type="hidden" value="<?= $_GET['id'] ?>" name="product_id" id="product_id" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col">
                        <h1>แก้ไขสินค้า</h1>
                    </div>
                </div>
                <table class="mai">
                    <tr>
                        <div class="row">
                            <div class="col-11">
                                <th>&nbsp รายละเอียดสินค้า</th>
                            </div>
                        </div>
                    </tr>
                    <tr>
                        <th>
                            <div class="row a">
                                <div class="col-4">
                                    ประเภทสินค้า : <b class="bb"><?= $rows['category_name']; ?></b>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-4 productname">
                                    ชื่อสินค้า : </span><b class="bb"><?= $p['product_name']; ?></b>
                                </div>
                                <div class="col-4 sellername">
                                    ชื่อผู้ขาย : <b class="bb"><?= $sells['sell_name']; ?></b>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-4 productversion">
                                    รุ่นสินค้า : </span><b class="bb"><?= $p['model']; ?></b>
                                </div>
                                <div class="col-4 brand">
                                    ยี่ห้อสินค้า : </span><b class="bb"><?= $p['brand']; ?></b>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-6 image">
                                    รูปภาพสินค้า :<span style="color: red; ">&nbsp*</span>
                                    <input type="file" accept="image/*" name="product_img1" id="product_img1" class="inbox" value="<?= $p['product_img']; ?>">
                                </div>
                                <div class="col productinformation">
                                    รูปรายละเอียดสินค้า :<span style="color: red; ">&nbsp*</span>
                                    <input type="file" accept="image/*" name="product_img2" id="product_img2" class="inbox" value="<?= $p['product_detail_img']; ?>">
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-6">
                                    <h6><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png
                                        ขนาดไฟล์ไม่เกิน 8 MB</h6>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-11 details">
                                    รายละเอียด :&nbsp&nbsp&nbsp
                                    <textarea name="product_detail" id="product_detail" rows="5" class="inbox" style="vertical-align:top;">
                                    <?= $p['product_detail']; ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-5 unit">
                                    หน่วยนับ :<b class="bb"><?= $p['product_unit']; ?></b>
                                </div>
                                <div class="col-4 price">
                                    ราคาขาย :<span style="color: red; ">&nbsp*</span>
                                    <input name="price" type="text" id="price" class="inbox" value="<?= $p['price']; ?>" required />
                                </div>
                                <div class="col-2 vax">
                                    <input style="transform: scale(1.5)" type="checkbox" class="vaxcheckbox" name="vat" <?= $p['vat'] == 1 ? "checked" : ''; ?> />
                                    <label class="vaxcheckboxtext">&nbsp;ภาษีมูลค่าเพิ่ม</label>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-5 min1">
                                    สินค้าคงคลังขั้นต่ำ :<span style="color: red; ">&nbsp*</span>
                                    <input name="notification_amt" type="text" id="notification_amt" class="inbox" value="<?= $p['notification_amt']; ?>" />
                                    <!--notification_amt = notification amount-->
                                </div>
                                <div class="col-4 amount">
                                    จำนวน :<span style="color: red; ">&nbsp*</span>
                                    <input name="product_dlt_unit" type="text" id="product_dlt_unit" class="inbox" value="<?= $p['product_dlt_unit']; ?>" required />
                                </div>
                                <div class="col-2 watchcostprice">
                                    <a type="button" href="costprice.php?id=<?= $p['product_id']; ?>" class="button btn">ดูราคาทุน</a>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-3 exchange">
                                    <input style="transform: scale(1.5)" type="checkbox" name="set_exchange" id="set_exchange" <?= $p['set_exchange'] == 0 ? "" : "checked" ?> />
                                    <label>&nbsp;สถานะการเปลี่ยนสินค้า</label>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-4 settingmin">
                                    <input style="transform: scale(1.5)" name="set_n_amt" id="set_n_amt" type="checkbox" <?= $p['set_n_amt'] == 0 ? "" : "checked" ?> />
                                    <label for="set_n_amt">&nbsp;ตั้งค่าสินค้าคงคลังขั้นต่ำล่วงหน้า</label>
                                </div>
                            </div>
                            <div class="row a" id="post">
                                <div class="col-4 start">
                                    วันที่เริ่มใช้งาน :<span style="color: red; ">&nbsp*</span>
                                    <input name="date_n_amt" type="date" id="date_n_amt" class="inbox" value="<?= $p['date_n_amt']; ?>" />
                                </div>
                                <div class="col-4 min2">
                                    สินค้าคงคลังขั้นต่ำ :<span style="color: red; ">&nbsp*</span>
                                    <input name="notification_amt2" type="text" id="notification_amt2" class="inbox" value="<?= $p['notification_amt2']; ?>" />
                                </div>
                            </div>
                            <br>
                        </th>
                    </tr>
                </table>
                <div class="row btn-g">
                    <div class="col-2">
                        <button type="button" onclick="window.location= 'productresult.php'" class="btn-c reset">ยกเลิก</button>
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn-c submit" value="บันทึก" />
                    </div>
                </div>
            </div>
    </form>
</body>
<script src="./src/js/editproduct.js"></script>
<script>
    $(document).ready(function() {
        if (<?= $p['set_n_amt'] ?> == 0) {
            $('#post').hide()
        } else {
            $('#post').show()
        }
    });
</script>

</html>