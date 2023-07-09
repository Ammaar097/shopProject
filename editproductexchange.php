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
    <link rel="stylesheet" href="./src/css/editproductexchange.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


</head>

<?php
include_once('nav.php');
include_once "./database/ProductExchange.php";
$productexchange = new ProductExchange();
$e = $productexchange->fetchExchange2Id($_GET['id']);
?>

<body>
    <form action="controller/ProductExchange.php" name="form1" id="form1" method="POST">
        <input type="hidden" value="productexchange" name="table" />
        <input type="hidden" value="update" name="form_action" />
        <input type="hidden" value="<?= $_GET['id'] ?>" name="product_exchange_id" id="product_exchange_id" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-11">
                        <h1>การเปลี่ยนสินค้า</h1>
                    </div>
                </div>
                <table class="mai">
                    <tr>
                        <th>
                            <div class="row a">
                                <div class="col productr">
                                    สินค้าที่ต้องการเปลี่ยน : &nbsp&nbsp</span>
                                    <input type="text" accept="image/*" name="product_name" id="product_name" value="<?= $e['product_name']; ?>" class="inbox" required />
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col productn">
                                    จำนวนที่เปลี่ยนสินค้า : &nbsp&nbsp</span>
                                    <input name="exchange_amount" min="1" step="1" value="1" type="number" id="exchange_amount" class="inbox" value="<?= $e['exchange_amount']; ?>" required />
                                </div>
                            </div>
                            <div class="row a ">
                                <div class="col ev">
                                    หลักฐานที่เสียหาย :<font color="red">&nbsp*</font>
                                    <input type="file" accept="image/*" name="damage_proof" id="damage_proof" class="inbox" value="<?= $e['damage_proof']; ?>" />
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col">
                                    <h5>*ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h5>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col comment">
                                    หมายเหตุ :&nbsp&nbsp&nbsp&nbsp<textarea name="note" id="note" cols="80" rows="5" class="inbox" value="<?= $e['note']; ?>" style="vertical-align:top;"></textarea>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col status">
                                    สถานะการเปลี่ยนสินค้า :<span style="color: red; ">&nbsp*</span>
                                    <input type="radio" name="exchange_status" id="exchange_status" class="inbox" value="complete">สำเร็จแล้ว
                                    <input type="radio" name="exchange_status" id="exchange_status" class="inbox" value="wait" checked>รอของ
                                </div>
                            </div>
                            <div class="desc" id="wait">
                                <div class="row a">
                                    <div class="col name">
                                        ชื่อ :<span style="color: red; ">&nbsp*</span>
                                        <input name="exchange_name" type="text" id="exchange_name" class="inbox" value="<?= $e['exchange_name']; ?>" />
                                        <!--ดูชื่อ class และ id จากเพื่อน-->
                                    </div>
                                </div>
                                <div class="row a tel">
                                    <div class="col">
                                        เบอร์โทรติดต่อ :<span style="color: red; ">&nbsp*</span>
                                        <input onkeyup="autoTab2(this)" name="exchange_tel" type="text" id="exchange_tel" class="inbox" value="<?= $e['exchange_tel']; ?>" />
                                        <!--ดูชื่อ class และ id จากเพื่อน-->
                                    </div>
                                </div>
                            </div>
            </div>
            </th>
            </tr>
            </table>
            <div class="row btn-g">
                <div class="col-2">
                    <button type="reset" onclick="window.location= 'productexchangehistory.php'" class="btn-c reset">ยกเลิก</button>
                </div>
                <div class="col-2">
                    <input type="submit" class="btn-c submit" value="บันทึก" />
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./src/js/editproductexchange.js"></script>

</html>