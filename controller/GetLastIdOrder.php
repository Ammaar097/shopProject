<?php
include_once '../database/Order.php';
$order = new Order();
echo $order->getLastId();
