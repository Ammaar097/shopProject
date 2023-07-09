<?php
include_once('../database/Product.php');
if (isset($_GET['id'])) {
    $product = new Product();
    $rows = $product->fetchById($_GET['id']);
    echo json_encode($rows);
} else {
    http_response_code(400);
}
