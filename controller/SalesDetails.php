<?php
include_once '../database/SalesDetails.php';
$salesdetails = new SalesDetails();
if (isset($_POST)) {
    if ($_POST['table'] === 'salesdetails') {
        if ($_POST['form_action'] === 'update') {
            $salesdetails->update($_POST);
        } else if ($_POST['form_action'] === 'delete') {
            $salesdetails->delete($_POST['unique_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $salesdetails->insert($_POST);
        }
    }
} else {

    echo "Page Not found.";
}
