<?php
include_once '../database/CostPrice.php';
include_once 'Redirection.php';
$costprice = new CostPrice();
if (isset($_POST)) {
    if ($_POST['table'] === 'costprice') {
        if ($_POST['form_action'] === 'update') {
            $costprice->update($_POST);
        } else if ($_POST['form_action'] === 'delete') {

            $costprice->delete($_POST['category_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $costprice->insert($_POST);
            redirection("/productresult.php");
        }
    }
} else {
    echo "Page Not found.";
}
