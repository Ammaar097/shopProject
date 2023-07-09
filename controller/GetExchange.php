<?php
include_once('../database/ProductExchange.php');
if (isset($_GET['id'])) {
    $productexchange = new ProductExchange();
    $rows = $productexchange->fetchById($_GET['id']);
    echo json_encode($rows);
} else {
    http_response_code(400);
}
