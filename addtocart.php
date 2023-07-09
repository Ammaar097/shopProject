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
    <link rel="stylesheet" href="./src/css/addtocart.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>
<?php
include_once('nav.php');
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <!-- หัวข้อหลัก -->
            <div class="row main">
                <div class="col">
                    <h1>รถเข็นสินค้า<h1>
                </div>
            </div>
            <!--ตาราง-->
            <!--เนื้อหา-->
            <table class="col-11 tablesales">
                <thead>
                    <tr class="TRTOPICCSS">
                        <th style="width : 10%; border-right: 1px; text-align: center; ">ลำดับ</th>
                        <th style="width : 15%; border-left: 1px; border-right: 1px;">รูปภาพ</th>
                        <th style="width : 25%; border-left: 1px; border-right: 1px; ">สินค้า</th>
                        <th style="width : 15%; border-left: 1px; border-right: 1px; ">ราคาต่อชิ้น</th>
                        <th style="width : 12%; border-left: 1px; border-right: 1px; ">จำนวน</th>
                        <th style="width : 15%; border-left: 1px; border-right: 1px; ">ราคารวม</th>
                        <th style="width : 8%; border-left: 1px; "><button onclick="del2()" class="TEXTNOTICE" id="Delall">ลบทั้งหมด</button></th>
                    </tr>
                </thead>
                <tbody id="addtocartTable"></tbody>
                <tbody>
                    <tr class="TRTOPICCSS">
                        <th colspan="2" style="border-right: 1px">
                            <select name="payment_s" id="payment_s" required>
                                <option value="เลือกประเภทการชำระ" selected hidden>เลือกประเภทการชำระ</option>
                                <option value="เงินสด">เงินสด</option>
                                <option value="โอนผ่านบัญชีธนาคาร">โอนผ่านบัญชีธนาคาร</option>
                                <option value="ผ่อนชำระ">ผ่อนชำระ</option>
                            </select>
                        </th>
                        <th colspan="4" style="border-left: 1px; border-right: 0px;">
                            <div class=" d-flex justify-content-end" style="margin-left: 3rem;">
                                <h5 class="TEXTNOTICE">จำนวน <span id="allquantity">0</span> ชิ้น &nbsp</h5>
                                <h5 class="TEXTNOTICE">ยอดรวมทั้งหมด : <span id="allprice">0</span> บาท &nbsp &nbsp</h5>
                                <button type="button" id="mySubmit" class="TEXTNOTICE" data-bs-toggle="modal">ยืนยัน</button>
                            </div>
                        </th>
                        <th style="border-left: 0px; "></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ยืนยันการซื้อแบบเงินสด -->
    <div class="modal fade bd-example-modal-sm3 cash-form" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="controller/Sales.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="sales" name="table" />
            <input type="hidden" value="insert" name="form_action" />
            <input type="hidden" id="payment_sl" name="payment_sl" value="เงินสด" />
            <input type="hidden" id="employee_id" name="employee_id" value="<?= $_SESSION['employee_id'] ?>">
            <input type="hidden" name="all_quantity" class="inbox all_quantity" />
            <input type="hidden" name="all_price" class="inbox all_price" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title2" id="exampleModalLabel">รับเงินสด</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col allprice"> ยอดรวมทั้งหมด : <label id="all_price" class="inbox all_price" /></label> &nbsp&nbspบาท </div>
                        </div>
                        <div class="row">
                            <div class="col receivecash"> เงินที่รับมา :<span style="color: red; ">&nbsp*</span> <input type="text" id="receivecash" class=" re" required /> &nbspบาท </div>
                        </div>
                        <div class="row fo">
                            <div class="col change"> เงินทอน : </div><label id="change" class="col mt"></label>
                            <div class="col inbox1">บาท </div>

                        </div>
                    </div>
                    <div class="modal-footer"> <button type="submit" id="pay_C" class="btn btn-primary1">ตกลง</button> </div>
                </div>
            </div>
    </div>
    </form>

    <!-- ยืนยันการซื้อแบบโอนผ่านธนาคาร -->
    <div class="modal fade bd-example-modal-sm4 transfer-form" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="controller/Sales.php" name="form2" id="form2" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="sales" name="table" />
            <input type="hidden" value="insert" name="form_action" />
            <input type="hidden" id="payment_sl" name="payment_sl" value="โอนผ่านบัญชีธนาคาร" />
            <input type="hidden" id="employee_id" name="employee_id" value="<?= $_SESSION['employee_id'] ?>">
            <input type="hidden" name="all_quantity" class="inbox all_quantity" />
            <input type="hidden" name="all_price" class="inbox all_price" />
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title2" id="exampleModalLabel">แนบใบสลิปธนาคาร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col importfile">
                                แนบใบสลิปธนาคาร : <input type="file" class="im" id="import_files" name="import_files" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col notice">
                                <h6><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col detail">
                                หมายเหตุ : <input type="text" class="de" id="note" name="note" required />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary1">ตกลง</button>
                    </div>
                </div>
            </div>
    </div>
    </form>

    <!-- ยืนยันการซื้อแบบผ่อนชำระ -->
    <div class="modal fade bd-example-modal-sm5 login-form" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title2" id="exampleModalLabel">กรอกรหัสเจ้าของร้าน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col email">
                            E-mail : <input type="text" name="email" id="email" class="btnd inbox" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col password">
                            รหัสผ่าน : <input type="text" name="password" id="password" class="btnd inbox" />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary1">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ยืนยันการซื้อแบบผ่อนชำระ(ต่อ 1) -->
    <form action="controller/Sales.php" name="form3" id="form3" method="POST">
        <div class="modal fade bd-example-modal-xl search-costumer-form" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <input type="hidden" value="sales" name="table" />
            <input type="hidden" value="insert" name="form_action" />
            <input type="hidden" id="payment_sl" name="payment_sl" value="ผ่อนชำระ" />
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title2" id="exampleModalLabel">ค้นหาลูกค้า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <br>
                        <div class="row">
                            <div class="col email">
                                กรอกรหัสบัตรประชาชน : <input type="text" name="keyword" id="keyword" class="btnd inbox" onkeyup="autoTab(this)" required />
                            </div>
                            <div class="col-1">
                                <click id="search" type="submit"><img src="./src/images/search.png" width="25" class="l"></click>&nbsp &nbsp
                            </div>
                        </div>
                        <br>
                        <span id="salestocontracttable"></span>
                    </div>
                    <div class="modal-footer">
                        <a name="btAddContact_Click()" id="next-add" href="#" class="btn btn-primary1">ถัดไป</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./src/js/addtocart.js"></script>
<script>
    function convertToDateThai(date) {
        var month_th = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return result = date.getDate() + " " + month_th[(date.getMonth() + 1)] + " " + (date.getFullYear() + 543);
    }

    var input = document.getElementById("keyword");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
</script>

</html>