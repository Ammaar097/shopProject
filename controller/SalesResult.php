<?php
include_once('../database/Sales.php');
if (!isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $sales = new Sales();
    $rows = $sales->fetchAll();
    echo json_encode($rows);
}
