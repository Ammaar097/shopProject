<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/customer.css" />

</head>
<?php
include_once('nav2.php');
include_once('./database/Product.php');
include_once('./database/Category.php');
include_once('./database/Search.php');
include_once('./database/Search_Category.php');
$product = new Product();
$category = new Category();
$search = new Search();
$search_cat = new Search_Category();
if (isset($_GET['category'])) {
    $row = $product->fetchByCategoryId($_GET['category']);
    $pl['category_id'] = $_GET['category'];
    $catName = $category->fetchById($_GET['category']);
    $catName = $catName['category_name'];
    $search_cat->insert($pl);
} else if (isset($_GET['keyword'])) {
    $catName = "สินค้าทั้งหมด";
    $row = $product->fetchByName($_GET['keyword']);
    $search->insert($_GET);
} else {
    $row = $product->fetchAll();
    $catName = "สินค้าทั้งหมด";
}


?>

<body>
    <form>
        <div class="col a">
            <h5 class="b">ประเภทสินค้า : <?= $catName ?></h5>
        </div>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar2.php'); ?></div>
            <div class="col-11">
                <div class="col main row-5" style="margin-top:20px;">
                    <?php foreach ($row as $r) { ?>
                        <a href="customer2.php?product=<?= $r['product_id'] ?>" name="btCustomer_click()" class="button" style="margin:10px;">
                            <span style="font-size: 15pt !important; "><?= $r['product_name'] ?></span><br><br>
                            <img src="<?= file_exists($r['product_img']) ? $r['product_img'] : "./src/images/logo.png" ?>" width="150" height="150"><br>
                            <p></p>
                            <div class="d-flex justify-content-end">
                                <span style="font-size: medium; "><?= number_format($r['price']) ?>&nbsp;บาท&nbsp;&nbsp;</span>
                            </div>
                            <div class="d-flex justify-content-end">
                                <span style="font-size: medium; "><?= $r['product_rm_unit'] ?>&nbsp;<?= $r['product_unit'] ?>&nbsp;&nbsp;</span>
                            </div>
                        </a>
                    <?php } ?>
                    <?= count($row) <= 0 ? "<div style='text-align: center; font-size: 24px;'>ไม่พบสินค้าที่ต้องการ</div>" : "" ?>
                </div>
    </form>
</body>

</html>