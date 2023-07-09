<?php
include_once '../database/Sell.php';
include_once '../service/upload.php';
include_once '../database/Bank.php';
include_once 'Redirection.php';
$bank = new Bank();
$sell = new Sell();
if (isset($_POST)) {
    if ($_POST['table'] === 'sell') {
        if ($_POST['form_action'] === 'update') {
            //เชคการอัพโหลดรูป
            if ($_FILES['seller_card_id']['size'] > 0) {
                $path = './file/seller/id/';
                if (file_exists($_POST['seller_card_id'])) {
                    unlink($_POST['seller_card_id']);
                }
                $filesname = $path . uploadImage($_FILES['seller_card_id'], "." . $path);
                if ($filesname) {
                    $sell->updateimage('seller_card_id', $filesname, $_POST['sell_id']);
                }
            }
            if ($_FILES['seller_cardname']['size'] > 0) {
                $path = './file/seller/card/';
                if (file_exists($_POST['seller_cardname'])) {
                    unlink($_POST['seller_cardname']);
                }
                $filesname = $path . uploadImage($_FILES['seller_cardname'], "." . $path);
                if ($filesname) {
                    $sell->updateimage('seller_cardname', $filesname, $_POST['sell_id']);
                }
            }
            if ($_FILES['sell_documents']['size'] > 0) { //มีขนาดรูปมากกว่า0 รูปไม่หาย
                $path = './file/seller/documents/';
                if (file_exists($_POST['sell_documents'])) {
                    unlink($_POST['sell_documents']);
                }
                $filesname = $path . uploadImage($_FILES['sell_documents'], "." . $path);
                if ($filesname) {
                    $sell->updateimage('sell_documents', $filesname, $_POST['sell_id']);
                }
            }

            $banks = json_decode($_POST['bank']);
            $tempbanks = [];
            foreach ($banks as $b) {
                $tempbanks[] = (array)$b;
            }
            $banks = $tempbanks;
            // remove bank and edit
            $recBack = $bank->fetchBySellId($_POST['sell_id']);
            foreach ($recBack as $r) {
                $f = false;
                foreach ($banks as $value) {
                    $f = $f  || ($r['bank_id'] == $value['id']);
                }
                if (!$f) {
                    $bank->delete($r['bank_id']);
                } else {
                    $form = [];
                    $form['bank_id'] =  $r['bank_id'];
                    $form['sell_id'] =  $_POST['sell_id'];
                    $form['bank_name'] = $value['bank'];
                    $form['bank_number'] =  $value['number'];
                    $form['bank_account'] =  $value['name'];
                    $bank->update($form);
                }
            }
            // insert bank to edit
            foreach ($banks as $value) {
                if ($value['id'] == -1) {
                    $form = [];
                    $form['sell_id'] =  $_POST['sell_id'];
                    $form['bank_name'] = $value['bank'];
                    $form['bank_number'] =  $value['number'];
                    $form['bank_account'] =  $value['name'];
                    $bank->insert($form);
                }
            }
            $sell->update($_POST);
            Redirection("/sall.php");
        } else if ($_POST['form_action'] === 'delete') {
            if (file_exists($_POST['seller_card_id'])) {
                unlink($_POST['seller_card_id']);
            }
            if (file_exists($_POST['seller_cardname'])) {
                unlink($_POST['seller_cardname']);
            }
            if (file_exists($_POST['sell_documents'])) {
                unlink($_POST['sell_documents']);
            }
            $bank->deleteBySellId($_POST['sell_id']);
            $sell->delete($_POST['sell_id']);
        } else if ($_POST['form_action'] === 'insert') {
            if ($_FILES['seller_card_id']['size'] > 0) {
                $path = './file/seller/id/';
                $filesname = uploadImage($_FILES['seller_card_id'], "." . $path);
                if ($filesname) {
                    $_POST['seller_card_id'] = $path . $filesname;
                } else {
                    $_POST['seller_card_id'] = '';
                }
            } else {
                $_POST['seller_card_id'] = '';
            }

            if ($_FILES['seller_cardname']['size'] > 0) {
                $path = './file/seller/card/';
                $filesname = uploadImage($_FILES['seller_cardname'], "." . $path);
                if ($filesname) {
                    $_POST['seller_cardname'] = $path . $filesname;
                } else {
                    $_POST['seller_cardname'] = '';
                }
            } else {
                $_POST['seller_cardname'] = '';
            }

            if ($_FILES['sell_documents']['size'] > 0) {
                $path = './file/seller/documents/';
                $filesname = uploadImage($_FILES['sell_documents'], "." . $path);
                if ($filesname) {
                    $_POST['sell_documents'] = $path . $filesname;
                } else {
                    $_POST['sell_documents'] = '';
                }
            } else {
                $_POST['sell_documents'] = '';
            }
            $_POST['seller_card_id'] = str_replace("-", "", $_POST['seller_card_id']);
            $_POST['seller_cardname'] = str_replace("-", "", $_POST['seller_cardname']);
            $_POST['sell_documents'] = str_replace("-", "", $_POST['sell_documents']);
            $sell->insert($_POST);
            $last = $sell->fetchLast();
            $lastID = $last['sell_id'];
            $banks = json_decode($_POST['bank']);
            foreach ($banks as $value) {
                $form = [];
                $form['sell_id'] =  $lastID;
                $form['bank_name'] = $value->bank;
                $form['bank_number'] =  $value->number;
                $form['bank_account'] =  $value->name;
                $bank->insert($form);
            }
            $sell->insert($_POST);
            Redirection("/sall.php");
        }
    }
} else {
    echo "Page Not found.";
}
