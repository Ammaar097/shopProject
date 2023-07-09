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
    <link rel="stylesheet" href="./src/css/addcontract.css" />

</head>

<?php include_once('nav.php');
include_once "./database/Employee.php";
include_once "./database/Contract.php";
include_once "./service/datetimeDisplay.php";
$contract = new Contract();
$employee = new Employee();
$laber = $employee->fetchLabers();
$c = $contract->fetchAll();
$prefix_set = ['นาย', 'นาง', 'นางสาว'];
if (isset($_GET['cardID'])) {
    $contract_data = $contract->searchBycopyID($_GET['cardID']);
    if (count($contract_data) > 0) {
        $contract_data = $contract_data[0];
        $name = $contract_data['customer_firstname'];
        $lastname = $contract_data['customer_lastname'];
        $cardId = $_GET['cardID'];
        $prefix = $contract_data['customer_prefix'];
    } else {
        $name = "";
        $lastname = "";
        $cardId = "";
        $prefix = "";
    }
} else {
    $name = "";
    $lastname = "";
    $cardId = "";
    $prefix = "";
}
?>

<body>
    <form action="controller/Contract.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="sales_list_id" id="sales_list_id" />
        <input type="hidden" name="table" value="contract" />
        <input type="hidden" name="form_action" value="insert" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>สัญญาซื้อขาย</h1>
                </div>
                <div class="row">
                    <div class="col no">
                        ฉบับที่ : <b class="bb"></b><?= count($contract->fetchAll()) + 1 ?></b>
                    </div>
                    <div class="col datec">
                        วันที่ทำสัญญา :
                        <input type="date" name="date_contract" id="date_contract" value="<?= date('Y-m-d') ?>" class="bb" required />
                    </div>
                </div>
                <div class="row-3 xx">ข้าพเจ้า : <select name="employee_id" id="employee_id" class="bb" style="background-color: #D4DDC6;" required>
                        <option value="all" selected hidden>เลือกเจ้าของร้าน</option>
                        <?php $count = 1;
                        foreach ($laber as $s) {
                            $count++; ?>
                            <option value="<?= $s['employee_id'] ?>" id="S<?= $s['employee_id']; ?>" <?= $s['employee_status'] == 0 ? "disabled" : ""; ?> <?= $s['employee_firstname'] === "วิทูรย์" ? "selected" : '' ?> onchange="setStatus(<?= $s['employee_id']; ?>)"> <?= $s['employee_prefix'] ?><?= $s['employee_firstname'] ?>&nbsp&nbsp<?= $s['employee_lastname'] ?></option>
                        <?php } ?>
                    </select> &nbsp;ซึ่งต่อไปในหนังสือสัญญานี้เรียกว่าผู้ขายฝ่ายหนึ่งกับ
                    <div class="b">*</div>
                </div>
                <div class="row">
                    <div class="col customerp">ข้าพเจ้า :
                        <?php if ($prefix == '') { ?>
                            <select name="customer_prefix" id="customer_prefix" style="background-color: #D4DDC6;" class="bb" required>
                                <option value="all" selected hidden>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        <?php } else if (!in_array($prefix, $prefix_set)) { ?>
                            <select name="customer_prefix" id="customer_prefix" style="background-color: #D4DDC6;" class="bb" required>
                                <option value="all" selected hidden>เลือกคำนำหน้า</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select>
                        <?php } else { ?>
                            <select name="customer_prefix" id="customer_prefix" style="background-color: #D4DDC6;" class="bb" required>
                                <?php foreach ($prefix_set as $ps) { ?>
                                    <option value="<?= $ps ?>" <?= $prefix == $ps ? "selected" : "" ?>><?= $ps ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                        <div class="e">*</div>
                    </div>
                    <div class=" col namec">ชื่อ : <input type="text" name="customer_firstname" value="<?= $name ?>" id="customer_firstname" class="bb" required />
                        <div class="f">*</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col lastc">นามสกุล : <input type="text" name="customer_lastname" value="<?= $lastname ?>" id="customer_lastname" class="bb" required />
                        <div class="g">*</div>
                    </div>
                    <div class="col idcard">รหัสบัตรประชาชน : <input type="text" name="customer_img" value="<?= $cardId ?>" id="customer_img" class="bb" onkeyup="autoTab(this)" required />
                        <div class="h">*</div>
                    </div>
                </div>
                <div class="row xxx">ซึ่งต่อไปในหนังสือสัญญานี้เรียกว่าผู้ซื้อฝ่ายหนึ่งทั้งสองฝ่ายตกลงทำสัญญาซื้อขายทรัพย์สินมีดังข้อความต่อไปนี้
                </div>
                <div class="col ct">
                    ข้อ 1 ผู้ขายได้ขาย :
                    <textarea id="product_detail" class="bb" name="product_detail" cols="50" rows="5" style="vertical-align:top;" readonly></textarea>
                </div>
                <div class="row-1 xxx">ให้แก่ผู้ซื้อเป็นจำนวนเงิน <input type="text" name="baht" id="baht" class="baht" readonly /> บาท <input type="text" id="stang" name="stang" class="stang" class="stang" readonly /> สตางค์ (&nbsp;<input type="text" name="stangt" id="stangt" class="stangt" readonly />&nbsp;)
                </div>
                <div class="col-11 xxx">และยอมส่งมอบทรัพย์สินที่ขายให้แก่ผู้ซื้อวันที่&nbsp;<span>&nbsp;<input type="date" value="<?= date('Y-m-d') ?>" name="date_send" id="date_send" required></span>
                    และผู้ขายได้รับราคาดังกล่าวแล้วไปจากผู้ซื้อเสร็จแล้วตั้งแต่วันที่<span class="z">*</span>&nbsp;<span>&nbsp;<input type="date" value="<?= date('Y-m-d') ?>" id="price_send" name="price_send"></span></div>

                <div class="row xxx">ข้อ 2 ผู้ขายยอมสัญญาว่า
                    ทรัพย์สินซ่งผู้ขายนำมาขายให้แก่ผู้ซื้อนี้เป็นทรัพย์สินของผู้ขายคนเดียว และไม่เคยนำไปขาย จำนำ
                    หรือทำสัญญาผูกพันธ์ใด ๆ แก่ผู้ใดเลย
                </div>
                <div class="col ctc">
                    ข้อ 3 : <span style="color: red; ">&nbsp*&nbsp&nbsp&nbsp&nbsp
                        <textarea name="contract_details" id="contract_details" cols="50" rows="5" style="vertical-align:top;"></textarea>
                </div>
                <div class="row xxx">ข้อ 4 ผู้ขายและผู้ซื้อได้ทราบข้อความในสัญญานี้ดีแล้ว
                    จึงได้ลงลายมือชื่อไว้ในสัญญานี้เป็นหลักฐาน
                </div>
                <!--
                <div class="row">
                <div class="col d-flex justify-content-end rr">ลงชื่อ &nbsp; &nbsp;
                    <select name="witness1_prefix" id="witness1_prefix" style="background-color: #D4DDC6;">
                        <option value="เลือกคำนำหน้า" selected hidden>เลือกคำนำหน้า</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>&nbsp;&nbsp;
                    ชื่อ : &nbsp; &nbsp;<input type="text" name="witness1_name" id="witness1_name">&nbsp;&nbsp;
                    นามสกุล : &nbsp; &nbsp;<input type="text" name="witness1_lastname" id="witness1_lastname">&nbsp;&nbsp;
                    พยานคนที่ 1
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-end rr">ลงชื่อ &nbsp; &nbsp;
                    <select name="witness2_prefix" id="witness2_prefix" style="background-color: #D4DDC6;">
                        <option value="เลือกคำนำหน้า" selected hidden>เลือกคำนำหน้า</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>&nbsp;&nbsp;
                    ชื่อ : &nbsp; &nbsp;<input type="text" name="witness2_name" id="witness2_name">&nbsp;&nbsp;
                    นามสกุล : &nbsp; &nbsp;<input type="text" name="witness2_lastname" id="witness2_lastname">&nbsp;&nbsp;
                    พยานคนที่ 2
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-end rr">ลงชื่อ &nbsp; &nbsp;
                    <select name="witness3_prefix" id="witness3_prefix" style="background-color: #D4DDC6;">
                        <option value="เลือกคำนำหน้า" selected hidden>เลือกคำนำหน้า</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>&nbsp;&nbsp;
                    ชื่อ : &nbsp; &nbsp;<input type="text" name="witness3_name" id="witness3_name">&nbsp;&nbsp;
                    นามสกุล : &nbsp; &nbsp;<input type="text" name="witness3_lastname" id="witness3_lastname">&nbsp;&nbsp;
                    พยานคนที่ 3
                </div>
            </div>-->
                <div class="row xxx">1. หากผู้ขายยังไม่ส่งมอบทรัพย์ให้ในเวลาทำสัญญา ควรจะเติมข้อความอีก 1
                    ข้อว่าตราบใดที่ผู้ขายยังไม่ส่งมอบทรัพย์ให้ ยังไม่ถือว่าได้มีการซื้อขาย
                    มิฉะนั้นผู้ซื้ออาจเสียเปรียบผู้ขาย
                </div>
                <div class="row xxx">2. สัญญาซื้อขายไม่ต้องปิดอากรแสตมป์ เว้นแต่จะถือว่าสัญญานี้เป็นใบรับเงินแล้ว
                    ถ้าสัญญาซื้อขายนี้ตั้งแต่ 10 บาท ถึง 20 บาท ต้องติดอากรแสตมป์ 10 สตางค์ ถ้าสัญญาซื้ขายนี้เกิน 20 บาท ทุก
                    20 บาท หรือเศษของ 20 บาท ต่อ 10 สตางค์ ถ้าสัญญาซื้อขายต่ำกว่า 10 บาท ไม่ต้องติดอากรแสตมป์
                </div>
                <div class="row btn-g">
                    <div class="col-2 buttom">
                        <input type="submit" class="btn-c submit" value="บันทึก" />
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules//sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./src/js/bahtText.js"></script>
<script src="./src/js/addcontract.js"></script>



</html>