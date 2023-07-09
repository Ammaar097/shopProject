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

if (!isset($_GET['id'])) {
    echo "not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/editconfirm2.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>
<?php
include_once "./database/Order.php";
include_once "./database/OrderDetails.php";
include_once "./database/OtherPrice.php";
include_once "./database/Product.php";
include_once "./service/datetimeDisplay.php";
$product = new Product();
$order = new Order();
$orderdetails = new OrderDetails();
$otherprice = new OtherPrice();
$products = $product->fetchAll();
$data = $order->fetchAllOrder2($_GET['id']);
$o = $order->fetchById($_GET['id']);
$od = $orderdetails->fetchByODId($_GET['id']);
$op = $otherprice->fetchByOPId($_GET['id']);
if (!$o) {
    echo "not found.";
    exit;
}

include_once('nav.php');
$json = '';
for ($i = 0; $i < count($od); $i++) {
    $b = $od[$i];
    $json .= "{
        list: " . $b['product_id'] . ",
        price: " . $b['order_pr'] . ",
        amount: " . $b['order_amt'] . ",
        expdate:\"" . "" . "\",
        allprice: " . $b['order_pr'] * $b['order_amt'] . ",
        id:" . $b['unique_id'] . "
    }";
    if ($i + 1 != count($od)) {
        $json .= ",";
    }
}
$json1 = '';
for ($k = 0; $k < count($op); $k++) {
    $t = $op[$k];
    $json1 .= "{
        listOther: \"" . $t['listother'] . "\",
        priceOther: " . $t['priceother'] . ",
        id: " . $t['unique_id'] . "
    }";
    if ($k + 1 != count($op)) {
        $json1 .= ",";
    }
}
?>

<body>
    <form action="controller/Order.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="bank_slip" value="<?= $o['invoice']; ?>" />
        <input type="hidden" name="bank_slip" value="<?= $o['invoice']; ?>" />
        <input type="hidden" name="table" value="order" />
        <input type="hidden" name="form_action" value="updateconfirm" />
        <input type="hidden" value="<?= $_GET['id'] ?>" name="order_id" id="order_id" />
        <input type="hidden" value="<?= $_GET['id'] ?>" name="product_id" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-4 topic">
                        <h1>ยืนยันใบสั่งซื้อ</h1>
                    </div>
                    <div class="col-8 d-flex justify-content-end" style="margin-top: 1rem;">
                        <div class="col-8" style="text-align: end;">
                            <b style="font-size: 20pt;">สถานะใบสั่งซื้อ &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</b>
                            <input style="transform:scale(2);" name="order_status" id="order_status" type="checkbox"> &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 20pt;">สำเร็จแล้ว</span>
                        </div>
                    </div>
                </div>
                <div class="pay">
                    <div class="row">
                        <div class="col datebill">
                            วันที่วางบิล : &nbsp;
                            <b><?= dateTimeDisplay($o['datebill']); ?></b>
                        </div>
                        <div class="col">
                            &nbsp;&nbsp;วันที่รับของ : &nbsp;
                            <b><?= dateTimeDisplay($o['datereceive']); ?></b>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col company">
                        ชื่อผู้ขาย : &nbsp;&nbsp;<b><?= $data['sell_name'] ?></b>
                    </div>
                </div>
                <div class="col note">
                    <label for="note">หมายเหตุ : &nbsp;</label>
                    <textarea name="note" id="note" cols="40" rows="4" style="vertical-align:top;" class="bb" value="<?= $o['note']; ?>"></textarea>
                </div>
                <div class="row">
                    <div class="col rein">
                        ใบเสร็จ : &nbsp;&nbsp;<input type="file" accept="image/*" name="receipt" id="receipt">
                    </div>
                    <div class="col">
                        ใบส่งของ : &nbsp;&nbsp;<input type="file" accept="image/*" name="invoice" id="invoice">
                    </div>
                </div>
                <div class="row-3">
                    <h6 class="leftpng"><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB </h6>
                </div>
                <br>
                <div class="col-11 C">
                    รายการสินค้า
                    <table class="ma col-10">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="25%">รายการสินค้า</th>
                                <th width="15%">ราคาต่อหน่วย (บาท)</th>
                                <th width="15%">จำนวน</th>
                                <th width="15%">ราคา (บาท)</th>
                                <th width="15%">วันหมดอายุ</th>
                                <th width="10%"><img src="./src/images/edit.png" width="25"></th>
                            </tr>
                        </thead>
                        <tbody id="list-product">
                            <?php $i = 0;
                            foreach ($od as $b) { ?>
                                <tr id="rr<?= $i ?>">
                                    <th class="index-table-product"><?= $i + 1 ?></th>
                                    <th id="text<?= $b['product_id'] ?>"><?= $b['product_name'] ?></th>
                                    <th><?= number_format($b['order_pr']) ?></th>
                                    <th><?= number_format($b['order_amt']) ?></th>
                                    <th><?= number_format($b['order_amt'] * $b['order_pr']) ?></th>
                                    <th></th>
                                    <th>
                                        <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(<?= $i ?>)"></button>
                                    </th>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-11 C">
                    ค่าใช้จ่ายอื่นๆ
                    <table class="ma col-10">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="45%">รายการ</th>
                                <th width="40%">ราคา</th>
                            </tr>
                        </thead>
                        <tbody id="list-priceother">
                            <?php $k = 0;
                            foreach ($op as $b) { ?>
                                <tr id="rr<?= $k ?>">
                                    <th class="index-table-price"><?= $k + 1 ?></th>
                                    <th><?= $b['listother'] ?></th>
                                    <th><?= number_format($b['priceother']) ?></th>
                                </tr>
                            <?php $k++;
                            } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row A">
                    <div class=" col-11 d-flex justify-content-end">
                        ยอดสุทธิ : &nbsp;&nbsp;<input type="hidden" name="all_price_odr" id="all_price_odr">
                        <span id="all_price_odr_text"></span>
                    </div>
                </div>

                <div class="row-10 btn-g">
                    <div class="col-2">
                        <button type="reset" class="btn-c reset">ยกเลิก</button>
                    </div>
                    <div class="col-2">
                        <input type="submit" class="btn-c submit" value="บันทึก" />
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>

    <!--เพิ่มสินค้า-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form id="addproduct" name="addproduct">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้า</h5>
                        <button type="button" class="close" id="addclose" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div> ชื่อสินค้า &nbsp;&nbsp;:&nbsp;&nbsp;
                                <select id="product_id" name="product_id" class="inbox3 ">
                                    <option value="all" selected hidden>เลือกสินค้า</option>
                                    <?php foreach ($products as $p) {  ?>
                                        <option value="<?= $p['product_id'] ?>"><?= $p['product_name'] ?>
                                            &nbsp;<?= $p['brand'] ?>&nbsp;&nbsp;<?= $p['model'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="q"> ราคาต่อหน่วย &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="0.25" step="0.25" name="order_pr" id="order_pr" required />
                            </div>
                            <div class="s"> จำนวน &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="1" name="order_amt" id="order_amt" required />
                            </div>
                            <div class="ss"> วันหมดอายุ &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="date" min="1" name="exp_date" id="exp_date" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="addtable" class="btn btn-primary1">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--แก้ไขสินค้า-->
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="editaddproduct" id="editaddproduct">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขสินค้า</h5>
                        <button type="button" class="close" id="editclose" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="rr"> ชื่อสินค้า &nbsp;&nbsp;:&nbsp;&nbsp;
                                <select class="r" id="editproduct_id" name="editproduct_id">
                                    <?php foreach ($products as $p) {  ?>
                                        <option value="<?= $p['product_id'] ?>" <?= $_GET['id'] == $p['product_id'] ? "selected" : "" ?>><?= $p['product_name'] ?>
                                            &nbsp;<?= $p['brand'] ?>&nbsp;&nbsp;<?= $p['model'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="q"> ราคาต่อหน่วย &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="0.25" step="0.25" name="editorder_pr" id="editorder_pr" required />
                            </div>
                            <div class="s"> จำนวน &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="1" name="editorder_amt" id="editorder_amt" required />
                            </div>
                            <div class="sss"> วันหมดอายุ &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="date" min="1" name="editexp_date" id="editexp_date" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="addtable2" class="btn btn-primary1">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <!--ค่าใช้จ่ายอื่นๆ-->
    <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="addprice" id="addprice" method="post">
            <div class="modal-dialog modal-sm1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มค่าใช้จ่ายอื่นๆ</h5>
                        <button type="button" id="addcloseother" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="listother">รายการ: &nbsp;<input type="text" name="listother" id="listother" required /><br>
                            <p></p>
                        </div>
                        <div class="priceother">ราคา: &nbsp;<input type="text" name="priceother" id="priceother" required />
                            <p></p>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" id="addtable2" class="btn btn-primary1">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--แก้ไขค่าใช้จ่ายอื่นๆ-->
    <div class="modal fade bd-example-modal-sm4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="editaddprice" id="editaddprice" method="post">
            <div class="modal-dialog modal-sm4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขค่าใช้จ่ายอื่นๆ</h5>
                        <button type="button" id="editaddcloseother" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align: center;">รายการ: &nbsp;<input type="text" name="editlistother" id="editlistother" required /><br>
                            <p></p>
                        </div>
                        <div style="text-align: center;">ราคา: &nbsp;<input type="text" name="editpriceother" id="editpriceother" required />
                            <p></p>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary1">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- ลบ -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ลบรายการ</h5>
                    <button type="button" id="closedelrow" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body1">
                    <h3>ยืนยันที่จะลบ</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="delrow()" class="btn btn-primary1">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#slipupload").hide()
        localStorage.clear()
        localStorage.setItem("tableProduct", JSON.stringify({
            data: [<?php echo $json; ?>]
        }))
        localStorage.setItem("tablePrice", JSON.stringify({
            data: [<?php echo $json1; ?>]
        }))
    });
</script>
<script src="./src/js/confirm2.js"></script>

</html>