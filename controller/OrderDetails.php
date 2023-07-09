<?php
include_once '../database/OrderDetails.php';
include_once 'Redirection.php';
$orderdetails = new OrderDetails();
if (isset($_POST)) {
    if ($_POST['table'] === 'orderdetails') {
        if ($_POST['form_action'] === 'update') {
            $orderdetails->update($_POST);
            //redirection('aaa.php');
        } else if ($_POST['form_action'] === 'delete') {
            $orderdetails->delete($_POST['unique_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $orderdetails->insert($_POST);
        }
    }
} else {
    echo "Page Not found.";
}
