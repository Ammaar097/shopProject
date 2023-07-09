<?php
include_once '../database/ProductExchange.php';
include_once '../database/Product.php';
include_once 'Redirection.php';
include_once '../service/upload.php';
$productexchange = new ProductExchange();
$product = new Product();
if (isset($_POST)) {
    if ($_POST['table'] === 'productexchange') {
        if ($_POST['form_action'] === 'update') {
            if ($_FILES['damage_proof']['size'] > 0) {
                $path = './file/productexchange/';
                if (file_exists($_POST['damage_proof'])) {
                    unlink($_POST['damage_proof']);
                }
                $filesname = $path . uploadImage($_FILES['damage_proof'], "." . $path);
                if ($filesname) {
                    $productexchange->updateimage('damage_proof', $filesname, $_POST['product_exchange_id']);
                }
            }
            if ($_POST['exchange_status'] != 'complete') {
                $_POST['exchange_status'] = '1';
            } else {
                $_POST['exchange_status'] = '0';
                $product->cutStock($_POST['product_id'], $_POST['exchange_amount']);
            }
            $productexchange->update($_POST);
            redirection("/productexchangehistory.php");
        } else if ($_POST['form_action'] === 'delete') {
            $productexchange->delete($_POST['product_exchange_id']);
        } else if ($_POST['form_action'] === 'insert') {
            //อัพโหลด
            if (isset($_FILES['damage_proof']['size'])) {
                $path = './file/productexchange/';
                $filesname = uploadImage($_FILES['damage_proof'], "." . $path);
                if ($filesname) {
                    $_POST['damage_proof'] = $path . $filesname;
                } else {
                    $_POST['damage_proof'] = '';
                }
            } else {
                $_POST['damage_proof'] = '';
            }
            if ($_POST['exchange_status'] != 'complete') {
                $_POST['exchange_status'] = '1';
            } else {
                $_POST['exchange_status'] = '0';
                $product->cutStock($_POST['product_id'], $_POST['exchange_amount']);
            }
            $productexchange->insert($_POST);
            redirection("/productexchangehistory.php");
        } else if ($_POST['form_action'] === 'status') {
            $productexchange->status($_POST['product_exchange_id']);
            redirection("/productexchangehistory.php");
        }
    }
} else {
    echo "Page Not found.";
}
