<?php
include_once '../database/Product.php';
$product = new Product();
if (isset($_GET['term'])) {
    echo $product->autoComplete($_GET['term']);
}
