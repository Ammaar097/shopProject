<?php
include_once '../database/Product.php';
include_once 'Redirection.php';
include_once '../service/upload.php';
$product = new Product();
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_POST)) {
    if ($_POST['table'] == 'product') {
        if ($_POST['form_action'] == 'update') {
            $vat = $product->fetchVat($_POST['product_id']);
            $vatCheck = empty($_POST['vat']) ? 0 : 1;
            if (!$vatCheck == $vat) {
                if ($vatCheck == 0) {
                    $_POST['price'] = floor($_POST['price'] * 100 / 107);
                } else {
                    $_POST['price'] = $_POST['price'] + ceil($_POST['price'] * $_SESSION['vat'] / 100);
                }
            }
            if (empty($_POST['vat'])) {
                $_POST['vat'] = '0';
            } else {
                $_POST['vat'] = '1';
            }
            //เชคการอัพโหลดรูป
            if ($_FILES['product_img1']['size'] > 0) {
                $path = './file/product/image1/';
                if (file_exists($_POST['product_img1'])) {
                    unlink($_POST['product_img1']);
                }
                $filesname = $path . uploadImage($_FILES['product_img1'], "." . $path);
                if ($filesname) {
                    $product->updateimage('product_img', $filesname, $_POST['product_id']);
                }
            }
            if ($_FILES['product_img2']['size'] > 0) {
                $path = './file/product/image2/';
                if (file_exists($_POST['product_img2'])) {
                    unlink($_POST['product_img2']);
                }
                $filesname = $path . uploadImage($_FILES['product_detail_img'], "." . $path);
                if ($filesname) {
                    $product->updateimage('product_img2', $filesname, $_POST['product_id']);
                }
            }
            if (empty($_POST['sales_status'])) {
                $_POST['sales_status'] = '0';
            } else {
                $_POST['sales_status'] = '1';
            }
            if (empty($_POST['set_n_amt'])) {
                $_POST['set_n_amt'] = '0';
            } else {
                $_POST['set_n_amt'] = '1';
            }
            if (empty($_POST['set_exchange'])) {
                $_POST['set_exchange'] = '0';
            } else {
                $_POST['set_exchange'] = '1';
            }
            $product->update($_POST);
            redirection('/productresult.php');
        } else if ($_POST['form_action'] == 'delete') {
            $product->delete($_POST['product_id']);
        } else if ($_POST['form_action'] == 'insert') {
            if (!empty($_POST['vat'])) {
                $_POST['price'] = $_POST['price'] + ceil($_POST['price'] * $_SESSION['vat'] / 100);
            }
            if (empty($_POST['vat'])) {
                $_POST['vat'] = '0';
            } else {
                $_POST['vat'] = '1';
            }
            if ($_FILES['product_img1']['size'] > 0) {
                $path = './file/product/image1/';
                $filesname = uploadImage($_FILES['product_img1'], "." . $path);
                if ($filesname) {
                    $_POST['product_img1'] = $path . $filesname;
                } else {
                    $_POST['product_img1'] = '';
                }
            } else {
                $_POST['product_img1'] = '';
            }

            if ($_FILES['product_img2']['size'] > 0) {
                $path = './file/product/image2/';
                $filesname = uploadImage($_FILES['product_img2'], "." . $path);
                if ($filesname) {
                    $_POST['product_img2'] = $path . $filesname;
                } else {
                    $_POST['product_img2'] = '';
                }
            } else {
                $_POST['product_img2'] = '';
            }
            $_POST['sales_status'] = '1';
            if (empty($_POST['set_n_amt'])) {
                $_POST['set_n_amt'] = '0';
            } else {
                $_POST['set_n_amt'] = '1';
            }
            if (empty($_POST['set_exchange'])) {
                $_POST['set_exchange'] = '0';
            } else {
                $_POST['set_exchange'] = '1';
            }
            $_POST['product_img1'] = str_replace("-", "", $_POST['product_img1']);
            $_POST['product_img2'] = str_replace("-", "", $_POST['product_img2']);
            $product->insert($_POST);
            Redirection("/productresult.php");
        } else if ($_POST['form_action'] == 'cut') {
            $product->cutStock($_POST['q'], $_POST['product_id']);
        }
    }
} else {
    echo "Page Not found.";
}
