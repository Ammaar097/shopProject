<?php if (!isset($_SESSION)) {
    session_start();
}
include_once('./service/auth.php');
include_once('./database/Product.php');
isLogin();
$product = new Product();
$lost = $product->fetchLost();
?>
<html>
<link rel="shortcut icon" href="./src/images/892917.ico"/>
<link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css"/>
<link rel="stylesheet" href="./src/css/nav.css"/>
<nav class="navbar fixed-top navbar-expand-lg navbar-light navbar1" >
    <div class="container-fluid">
            <a class="navbar-brand nav-link index" href="index.php"> หน้าแรก &nbsp;</a>
            <?php if (getRole() == 'E' || getRole() == 'L') { ?>
            <a class='print' style="margin-right: auto;" href="notification_amt.php">
            <?php if(count($lost)>0){?><span class="bell"><?=count($lost)?></span><?php }?>
            <img  src="./src/images/bell.png" width="30"></a>
        <?php } ?>
            <button class="BT" onclick="logout()" style="background: transparent; border: none;"><?= $_SESSION['role'] !== 'A' ? $_SESSION['username'] : 'ผู้ดูแลระบบ' ?>&nbsp&nbsp&nbsp(<?= getFullRole($_SESSION['role']) ?>)</button>
    </div>
    </div>
</nav>
<script src="./node_modules//sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./src/js/nav.js"></script>

</html>