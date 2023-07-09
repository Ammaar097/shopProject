<?php
include_once '../database/Stock.php';
include_once 'Redirection.php';
$stock = new Stock();
if (isset($_POST)) {
    if ($_POST['table'] === 'stock') {
        if ($_POST['form_action'] === 'update') {
            $stock->update($_POST);
            //redirection('aaa.php');
        } else if ($_POST['form_action'] === 'delete') {
            $stock->delete($_POST['stock_id']);
        } else if ($_POST['form_action'] === 'insert') {
            $stock->insert($_POST);
            redirection("../stock.php");
        }else if($_POST['form_action'] == 'cut'){
            $stock->cut($_POST['q'],$_POST['stock_id']);
        }
    }
} else {
    echo "Page Not found.";
}
