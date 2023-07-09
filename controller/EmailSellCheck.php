<?php
include_once '../database/Sell.php';
$sell = new Sell();
if ($_GET['email']) {
    echo json_encode($sell->emailCheck($_GET['email']));
} else {
    echo "Page Not found.";
}
