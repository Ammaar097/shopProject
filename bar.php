<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once('service/auth.php');

if (!isset($_SESSION['shop_name'])) {
    $_SESSION['shop_name'] = "ร้านวรเชษฐ์เกษตรภัณฑ์";
}
?>
<title><?= $_SESSION['shop_name'] ?></title>
<link rel="stylesheet" href="./src/css/bar.css">
<nav class="nav flex-column bar">
    <h6></h6>
    <?php if (getRole() == 'E' || getRole() == 'L') { ?><h5>$ ขาย</h5>
        <hr /><?php } ?>
    <?php if (getRole() == 'E' || getRole() == 'L') { ?> <a class="nav-link bar-link" href="productlist.php">รายการขาย</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="contracthistory.php">สัญญาซื้อขาย</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="salehistory.php">ประวัติการขาย</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="productexchangehistory.php">การประกันสินค้า</a><?php } ?>
    <?php if (getRole() == 'L') { ?><h5><span><img src="./src/images/buy.png" width="25" height="25" /></span> ซื้อ</h5>
        <hr /><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="sall.php">ผู้ขาย</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="order.php">รายการใบสั่งซื้อ</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="orderhistory.php">ประวัติการสั่งซื้อ</a><?php } ?>
    <?php if (getRole() == 'L' || getRole() == 'E') { ?><h5><span><img src="./src/images/sell.png" width="25" height="25" /></span> สินค้า</h5>
        <hr /><?php } ?>
    <?php if (getRole() == 'E' || getRole() == 'L') { ?> <a class="nav-link bar-link" href="productresult.php">สินค้าทั้งหมด</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="category.php">ประเภทสินค้า</a><?php } ?>
    <?php if (getRole() == 'L') { ?><h5><span><img src="./src/images/employee.png" width="25" height="25" /></span> พนักงาน</h5>
        <hr /><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="employee.php">พนักงาน</a><?php } ?>
    <?php if (getRole() == 'L') { ?><h5><span><img src="./src/images/report.png" width="25" height="25" /></span> รีพอร์ต</h5>
        <hr /><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="budget.php">งบการเงิน</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="salessummary.php">การขาย</a><?php } ?>
    <?php if (getRole() == 'L' || getRole() == 'A') { ?><h5><span><img src="./src/images/setting.png" width="25" height="25" /></span> ตั้งค่า</h5>
        <hr /><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="contractsetting.php">สัญญาซื้อขาย</a><?php } ?>
    <?php if (getRole() == 'A') { ?> <a class="nav-link bar-link" href="manageuseraccounts.php">การจัดการบัญชีผู้ใช้</a><?php } ?>
    <?php if (getRole() == 'A') { ?> <a class="nav-link bar-link" href="shop_detail.php">การจัดการข้อมูลร้าน</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="changeproduct.php">การเปลียนสินค้า</a><?php } ?>
    <?php if (getRole() == 'L') { ?> <a class="nav-link bar-link" href="vat.php">ภาษีมูลค่าเพิ่ม</a><?php } ?>
</nav>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./src/js/bar.js"></script>