<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/customer2.css" />

</head>
<?php
include_once('nav2.php');
include_once('./controller/Redirection.php');
include_once('./database/Product.php');
include_once('./database/Category.php');
if (isset($_GET['product'])) {
    $product = new Product();
    $category = new Category();
    $r = $product->fetchById($_GET['product']);
    $cx = $category->fetchById($r['category_id']);
} else {
    redirection('/customer.php');
}

?>

<body>
    <form>
        <div class="row">
            <div class="col-9 a">
            </div>
            <div class="col d-flex justify-content-end">
                <button type="button" class="back" onclick="javascript:window.location='customer.php';"><img src="./src/images/left-arrow.png" width="40" style="margin-top: 0.7rem;"></button>
            </div>
        </div>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar2.php'); ?></div>
            <div class="col-8" style="margin-left: 5rem;">
                <div class="row z">
                    <div class="col-2">
                        <br>
                        <div id="carouselExampleIndicators" class="carousel" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="<?= file_exists($r['product_img']) ? $r['product_img'] : "./src/images/logo.png" ?>"><img src="<?= file_exists($r['product_img']) ? $r['product_img'] : "./src/images/logo.png" ?>" width="200"></a>
                                </div>
                                <div class="carousel-item">
                                    <img src="<?= file_exists($r['product_detail_img']) ? $r['product_detail_img'] : "./src/images/logo.png" ?>" width="200">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>
                    <div class="col-7"><br>
                        <div class="d-flex justify-content-between">
                            <p class="c"><?= $r['product_name'] ?></p>
                            <p class="o"><?= number_format($r['price']) ?> บาท</p>
                        </div>
                        <div class="n">รหัสสินค้า &nbsp;:&nbsp; <?= $r['product_id'] ?></div>
                        <p>
                        <div class="f">
                            ประเภทสินค้า &nbsp;:&nbsp; <?= $cx['category_name'] ?><br>
                            ยี่ห้อ &nbsp;:&nbsp; <?= $r['brand'] ?> <br>
                            คงเหลือ &nbsp;:&nbsp; <?= $r['product_rm_unit'] ?> <?= $r['product_unit'] ?> <br><br>
                        </div>
                        <div class="f">รายละเอียดสินค้า &nbsp;:&nbsp; <br><?= $r['product_detail'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</html>