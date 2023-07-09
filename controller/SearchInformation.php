<?php
include_once('../database/Search_Sales_Product_Exchange.php');
if (!isset($_GET['keyword'])) {
    $sales = new Search_Sales_Product_Exchange();
    $rows = [];
    echo json_encode($rows);
} else if (isset($_GET['keyword'])) {
    $sales = new Search_Sales_Product_Exchange();
    $rows = $sales->searchsales($_GET['keyword']);
    echo json_encode($rows);
}
