<?php
include_once '../database/Product.php';
$product = new Product();
if (isset($_GET['status']) && (isset($_GET['id']))) {
    $product->updateStatus($_GET['status'] == 'true' ? 1 : 0, $_GET['id']);
} else {
    echo "Page Not found.";
}
