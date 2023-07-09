<?php
include_once('../database/Stock.php');
if (isset($_GET['product_id'])) {
    $stock = new Stock();
    $rows = $stock->fetchByProductId($_GET['product_id']);
    echo json_encode($rows);
}
