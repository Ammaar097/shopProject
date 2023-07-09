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
    <link rel="stylesheet" href="./src/css/addorder.css" />


</head>

<?php
include_once('nav.php');
include_once "./database/Sell.php";
include_once "./database/Product.php";
$sell = new Sell();
$product = new Product();
$sells = $sell->fetchAll();
$product = $product->fetchAll();
?>


<body>
    <form action="controller/Order.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="table" value="order" />
        <input type="hidden" name="form_action" value="insert" />
        <input type="hidden" id="orderdetails" name="orderdetails" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-4 topic">
                        <h1>ใบสั่งซื้อ</h1>
                    </div>
                    <div class="pay">
                        <div class="row">
                            <div class="col datebill">
                                วันที่วางบิล : &nbsp;
                                <input type="date" name="datebill" id="datebill" value="<?= date('Y-m-d') ?>" required />
                            </div>
                            <div class="col">
                                &nbsp;&nbsp;วันที่รับของ : <span style="color: red; ">&nbsp*</span>
                                <input type="date" class="bb" name="datereceive" id="datereceive" value="<?= date('Y-m-d') ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col company">
                                ชื่อผู้ขาย : <span style="color: red; ">&nbsp*</span>
                                <select name="sell_id" id="sell_id" class="inbox bb" style="background-color: #D4DDC6;" width="10%" required>
                                    <option value="all" selected hidden>เลือกผู้ขาย</option>
                                    <?php foreach ($sells as $s) { ?>
                                        <option value="<?= $s['sell_id'] ?>"><?= $s['sell_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col j payment_sl">
                                วิธีการชำระเงิน : <span style="color: red; ">&nbsp*</span>
                                <select name="payment_sl" id="payment_sl" class="inbox2 bb" style="background-color: #D4DDC6;" required>
                                    <option value="all" selected hidden>เลือกวิธีการชำระ</option>
                                    <option value="เงินสด">เงินสด</option>
                                    <option value="เครดิต">เครดิต</option>
                                </select>
                            </div>
                            <div class="col payment">
                                วันที่ชำระเงิน : <span style="color: red; ">&nbsp*
                                    <input type="date" name="payment_dt" id="payment_dt" class="bb" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div id="creditupload">
                            <div class="col h">
                                สลิปธนาคาร : <span style="color: red; ">&nbsp*</span>
                                <input accept="image/*" type="file" id="bank_slip" name="bank_slip" class="bb">
                            </div>
                            <div class="col">
                                <h6 class="hh"><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB </h6>
                            </div>
                        </div>
                        <div class="col note">
                            <label for="note">หมายเหตุ : &nbsp;</label>
                            <textarea name="note" id="note" cols="50" rows="5" style="vertical-align:top;" class="bb"></textarea>
                        </div>
                        <div class="col-12 C">
                            รายการสินค้า
                            <div class=" col-12 d-flex justify-content-end">
                                <button type="button" onclick="madeoption()"  class="btn2" id="addmodel_btn" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">เพิ่มสินค้า
                                </button>
                            </div>
                            <table class="main col-10">
                                <thead>
                                    <tr>
                                        <th width="10%">ลำดับ</th>
                                        <th width="30%">รายการสินค้า</th>
                                        <th width="15%">ราคาต่อหน่วย (บาท)</th>
                                        <th width="15%">จำนวน</th>
                                        <th width="15%">ราคา (บาท)</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody id="list-product">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 C">
                            ค่าใช้จ่ายอื่นๆ
                            <div class=" col-12 d-flex justify-content-end">
                                <button type="button" class="btn2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm1">เพิ่ม
                                </button>
                            </div>
                            <table class="main col-10">
                                <thead>
                                    <tr>
                                        <th width="10%">ลำดับ</th>
                                        <th width="40%">รายการ</th>
                                        <th width="40%">ราคา</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody id="list-priceother"></tbody>
                            </table>
                        </div>
                        <input type="hidden" name="all_amount_odr" id="all_amount_odr">
                        <div class="row A">
                            <div class=" col-12 d-flex justify-content-end">
                                ยอดสุทธิ : &nbsp;&nbsp;
                                <input type="hidden" name="all_price_odr" id="all_price_odr" readonly>
                                <span id="all_price_odr_text"></span>
                            </div>
                        </div>
                        <div class="row btn-g">
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
                        <button type="button" id="addclose" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class=""> ชื่อสินค้า &nbsp;&nbsp;:&nbsp;&nbsp;
                                <select id="product_id" name="product_id" class="inbox3" required>
                                </select>
                            </div>
                            <div class="q"> ราคาต่อหน่วย &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="0.25" step="0.25" name="order_pr" id="order_pr" required />
                            </div>
                            <div class="s"> จำนวน &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="1" name="order_amt" id="order_amt" required />
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
        <form id="editaddproduct" name="editaddproduct">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขสินค้า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="editclose" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="rr"> ชื่อสินค้า &nbsp;&nbsp;:&nbsp;&nbsp;
                                <select class="r" id="editproduct_id" name="editproduct_id" style="background-color: #D4DDC6;" required>
                                </select>
                            </div>
                            <div class="q"> ราคาต่อหน่วย &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="0.25" step="0.25" name="editorder_pr" id="editorder_pr" required />
                            </div>
                            <div class="s"> จำนวน &nbsp;&nbsp;:&nbsp;&nbsp;
                                <input type="number" class="u" min="1" name="editorder_amt" id="editorder_amt" required />
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
    <!--ค่าใช้จ่ายอื่นๆ-->
    <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="addprice" id="addprice" method="post">
            <div class="modal-dialog modal-sm1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มค่าใช้จ่ายอื่นๆ</h5>
                        <button type="button" id="addcloseother" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
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
        <form name="addprice" id="editaddprice" method="post">
            <div class="modal-dialog modal-sm4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขค่าใช้จ่ายอื่นๆ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="editaddcloseother" aria-label="Close">
                            
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="listother">รายการ: &nbsp;<input type="text" name="listother" id="editlistother" required /><br>
                            <p></p>
                        </div>
                        <div class="priceother">ราคา: &nbsp;<input type="text" name="priceother" id="editpriceother" required />
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
    <!-- ลบรายการอื่นๆ -->
    <div class="modal fade" id="exampleModalother" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ลบรายการ</h5>
                    <button type="button" id="closedelrow2" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body1">
                    <h3>ยืนยันที่จะลบ</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="delrow2()" class="btn btn-primary1">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./src/js/printThis.js"></script>
<script src="./src/js/addorder3.js"></script>

</html>