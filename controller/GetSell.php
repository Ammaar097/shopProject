<?php
include_once('../database/Sell.php');
if (isset($_GET['id'])) {
    $sell = new Sell();
    $rows = $sell->fetchById($_GET['id']);
    echo json_encode($rows);
} else {
    http_response_code(400);
}
