<?php
include_once('../database/Product.php');
if (isset($_GET['id']) && isset($_GET['q'])) {
    $product = new Product();
    $rows = $product->fetchById($_GET['id']);
    echo ($rows['product_rm_unit'] >= $_GET['q'] ? 'true' : 'false');
} else {
    http_response_code(400);
}
