<?php
include_once '../database/Order.php';
$order = new Order();
if (isset($_GET['status']) && (isset($_GET['id']))) {
    $order->updateStatus($_GET['status'] == 'true' ? 1 : 0, $_GET['id']);
} else {
    echo "Page Not found.";
}
