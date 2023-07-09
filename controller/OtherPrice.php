<?php
include_once '../database/OtherPrice.php';
include_once 'Redirection.php';
$otherprice = new OtherPrice();
if (isset($_POST)) {
    if ($_POST['table'] === 'otherprice') {
        if ($_POST['form_action'] === 'update') {
            $otherprice->update($_POST);
            //redirection('aaa.php');
        } else if ($_POST['form_action'] === 'delete') {
            $otherprice->delete($_POST['unique_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $otherprice->insert($_POST);
        }
    }
} else {
    echo "Page Not found.";
}
