<?php
include_once 'database/OtherExpenses.php';
include_once 'Redirection.php';
$otherExpenses = new OtherExpenses();
if (isset($_POST)) {
    if ($_POST['table'] === 'otherExpenses') {
        if ($_POST['form_action'] === 'update') {
            $otherExpenses->update($_POST);
            //redirection('aaa.php');
        } else if ($_POST['form_action'] === 'delete') {
            $otherExpenses->delete($_POST['unique_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $otherExpenses->insert($_POST);
        }
    }
} else {
    echo "Page Not found.";
}
