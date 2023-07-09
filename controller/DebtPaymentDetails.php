<?php
include_once '../service/upload.php';
include_once '../database/DebtPaymentDetails.php';
include_once 'Redirection.php';
$debtPaymentDetails = new DebtPaymentDetails();
if (isset($_POST)) {
    if ($_POST['table'] === 'debtPaymentDetails') {
        if ($_POST['form_action'] == 'update') {
            $debtPaymentDetails->update($_POST);
            //redirection('aaa.php');
        } else if ($_POST['form_action'] == 'delete') {
            $debtPaymentDetails->delete($_POST['unique_id']);
        } else if ($_POST['form_action'] === 'insert') {
            if ($_FILES['slip_img']['size']) {
                //อัพโหลด
                $path = './file/debt/files';
                $filesname = uploadImage($_FILES['slip_img'], "." . $path);
                if ($filesname) {
                    $_POST['slip_img'] = $path . $filesname;
                } else {
                    $_POST['slip_img'] = '';
                }
            } else {
                $_POST['slip_img'] = '';
            }
            $debtPaymentDetails->insert($_POST);
        } else if ($_POST['form_action'] === 'upload') {
            if ($_FILES['slip_img']['size']) {
                //อัพโหลด
                $path = './file/debt/files';
                $filesname = uploadImage($_FILES['slip_img'], "." . $path);
                if ($filesname) {
                    $_POST['slip_img'] = $path . $filesname;
                } else {
                    $_POST['slip_img'] = "";
                }
            } else {
                $_POST['slip_img'] = "";
            }
            $u = $_POST['contract_code'];
            $debtPaymentDetails->upload($_POST);
            redirection('/repay.php?id=' . ($u));
            //_($u);

        } else if ($_POST['form_action'] === 'insertInit') {
            $debtPaymentDetails->insertinit($_POST);
        }
    }
} else {
    echo "Page Not found.";
}
