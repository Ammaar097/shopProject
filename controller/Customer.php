<?php
include_once 'database/Customer.php';
include_once 'database/Contract.php';
include_once 'Redirection.php';
$customer = new Customer();
if (isset($_POST)) {
    if ($_POST['table'] === 'customer') {
        if ($_POST['form_action'] === 'update') {
            $customer->update($_POST);
            //redirection('aaa.php');
        } else if ($_POST['form_action'] === 'delete') {
            $customer->delete($_POST['customer']);
        } else if ($_POST['form_action'] === 'insert') {
            $customer->insert($_POST);
        }
    }
} else {
    echo "Page Not found.";
}
