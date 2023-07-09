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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="./src/css/addproduct.css" />

</head>

<?php
include_once('nav.php');
include_once "./database/Category.php";
include_once "./database/Sell.php";
$sell = new Sell();
$category = new Category();
$rows = $category->fetchAll();
$sells = $sell->fetchAll();
?>

<body>
    <form action="controller/Product.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
        <input type="hidden" value="product" name="table" />
        <input type="hidden" value="insert" name="form_action" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <!-- หัวข้อหลัก -->
                <div class="row main">
                    <div class="col-5">
                        <h1>เพิ่มสินค้า</h1>
                    </div>
                </div>
                <!--ตาราง-->
                <table class="mai">
                    <!--หัวข้อรอง-->
                    <thead>
                        <tr>
                            <div class="row">
                                <div class="col-11 mm">
                                    <th>&nbsp รายละเอียดสินค้า</th>
                                </div>
                            </div>
                        </tr>
                    </thead>
                    <!--เนื้อหา-->
                    <tbody>
                        <tr>
                            <th>
                                <div class="row a">
                                    <div class="col-4">
                                        ประเภทสินค้า :<span style="color: red; ">&nbsp*</span>
                                        <select name="category_id" id="category_id" class="inbox" style="background-color: #D4DDC6;" required>
                                            <option value="all" selected hidden>เลือกประเภทสินค้า</option>
                                            <?php foreach ($rows as $row) { ?>
                                                <option value="<?= $row['category_id']; ?>"><?= $row['category_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!--<div class="col productnumber ">
                                รหัสสินค้า :&nbsp&nbsp
                                <label for="no." id="" class="inbox">A01
                                </label>
                            </div>-->
                                </div>
                                <div class="row a">
                                    <div class="col-4 productname">
                                        ชื่อสินค้า :<span style="color: red; ">&nbsp*</span>
                                        <input name="product_name" type="text" id="product_name" class="inbox" required />
                                    </div>
                                    <div class="col-4 sellername">
                                        ชื่อผู้ขาย :<span style="color: red; ">&nbsp*</span>
                                        <select name="sell_id" id="sell_id" class="inbox" style="background-color: #D4DDC6;" required>
                                            <option value="allsell" selected hidden>เลือกผู้ขาย</option>
                                            <?php foreach ($sells as $s) { ?>
                                                <option value="<?= $s['sell_id'] ?>"><?= $s['sell_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row a">
                                    <div class="col-4 productversion">
                                        รุ่นสินค้า :&nbsp&nbsp&nbsp
                                        <input name="model" type="text" id="model" class="inbox" />
                                    </div>
                                    <div class="col-4 brand">
                                        ยี่ห้อสินค้า :&nbsp&nbsp
                                        <input name="brand" type="text" id="brand" class="inbox" />
                                    </div>
                                </div>
                                <div class="row a">
                                    <div class="col-6 image">
                                        รูปภาพสินค้า :<span style="color: red; ">&nbsp*</span>
                                        <input type="file" accept="image/*" name="product_img1" id="product_img1" class="inbox" required>
                                    </div>
                                    <div class="col productinformation">
                                        รูปรายละเอียดสินค้า :&nbsp&nbsp&nbsp
                                        <input type="file" accept="image/*" name="product_img2" id="product_img2" class="inbox">
                                    </div>
                                </div>

                                <div class="row a">
                                    <div class="col-6">
                                        <h6><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                                    </div>
                                </div>

                                <div class="row a">
                                    <div class="col details">
                                        รายละเอียด :&nbsp&nbsp&nbsp
                                        <textarea name="product_detail" id="product_detail" rows="5" class="inbox" style="vertical-align:top;"></textarea>
                                    </div>
                                </div>
                                <div class="row a">
                                    <div class="col-5 unit">
                                        หน่วยนับ :<span style="color: red; ">&nbsp*</span>
                                        <select name="product_unit" id="product_unit" class="inbox" style="background-color: #D4DDC6;" required>
                                            <option value="allunit">เลือกหน่วยสินค้า</option>
                                            <option value="ซอง">ซอง</option>
                                            <option value="ขวด">ขวด</option>
                                            <option value="ชิ้น">ชิ้น</option>
                                            <option value="กล่อง">กล่อง</option>
                                            <option value="เครื่อง">เครื่อง</option>
                                            <option value="ถุง">ถุง</option>
                                            <option value="กระสอบ">กระสอบ</option>
                                        </select>
                                    </div>
                                    <div class="col-4 price">
                                        ราคาขาย :<span style="color: red; ">&nbsp*</span>
                                        <input name="price" type="number" min="0" step="0.25" id="price" class="inbox" required />
                                    </div>
                                    <div class="col-2 vax">
                                        <input style="transform: scale(1.5)" type="checkbox" class="vaxcheckbox" name="vat" />
                                        <label class="vaxcheckboxtext">ภาษีมูลค่าเพิ่ม</label>
                                    </div>
                                </div>
                                <div class="row a">
                                    <div class="col-5 min1">
                                        สินค้าคงคลังขั้นต่ำ :<span style="color: red; ">&nbsp*</span>
                                        <input name="notification_amt" type="number" min="0" step="1" id="notification_amt" class="inbox" required />
                                    </div>
                                    <div class="col-4 amount">
                                        จำนวน :<span style="color: red; ">&nbsp*</span>
                                        <input name="product_dlt_unit" type="number" min="0" step="1" id="product_dlt_unit" class="inbox" required />
                                    </div>
                                    <div class="col-2 watchcostprice">
                                        <a type="button" href="costprice2.php" class="button btn">ดูราคาทุน</a>
                                    </div>
                                </div>
                                <div class="row a">
                                    <div class="col-3 exchange">
                                        <input style="transform: scale(1.5)" type="checkbox" name="set_exchange" id="set_exchange" />
                                        <label>&nbsp;สถานะการเปลี่ยนสินค้า</label>
                                    </div>
                                </div>
                                <div class="row a">
                                    <div class="col-4 settingmin">
                                        <input style="transform: scale(1.5)" name="set_n_amt" id="set_n_amt" type="checkbox" />
                                        <label for="set_n_amt">&nbsp;ตั้งค่าสินค้าคงคลังขั้นต่ำล่วงหน้า</label>
                                    </div>
                                </div>
                                <div class="row a" id="post">
                                    <div class="col-4 start">
                                        วันที่เริ่มใช้งาน :
                                        <input name="date_n_amt" type="date" id="date_n_amt" class="inbox" />
                                    </div>
                                    <div class="col-4 min2">
                                        สินค้าคงคลังขั้นต่ำ :
                                        <input name="notification_amt2" type="text" id="notification_amt2" class="inbox" />
                                    </div>
                                </div>
                                <br>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <!--ปุ่มบันทึกและปุ่มยกเลิก-->
                <div class="row btn-g">
                    <div class="col-2">
                        <button type="button" onclick="window.location= 'productresult.php'" class="btn-c reset">กลับ
                        </button>
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn-c submit" value="บันทึก" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./src/js/addproduct.js"></script>

</html>