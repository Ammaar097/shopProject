<?php
include_once('../database/CostPrice.php');
include_once('../database/Product.php');
if (isset($_GET['product_id'])) {
    $product = new Product();
    $rows = $product->fetchByCategoryName($_GET['product_id']);
    echo json_encode($rows);
}
