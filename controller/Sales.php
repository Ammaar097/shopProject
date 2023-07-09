<?php
include_once '../database/Sales.php';
include_once '../service/upload.php';
include_once '../database/SalesDetails.php';
include_once 'Redirection.php';
$salesdetails = new SalesDetails();
$sales = new Sales();
if (isset($_POST)) {
    if ($_POST['table'] === 'sales') {
        if ($_POST['form_action'] === 'update') {
            if ($_FILES['import_files']['size'] > 0) {
                $path = './file/sales/sales_slip/';
                if (file_exists($_POST['import_files'])) {
                    unlink($_POST['import_files']);
                }
                $filesname = $path.uploadImage($_FILES['import_files'], "." . $path);
                if ($filesname) {
                    $sales->updateimage('import_files',$filesname,$_POST['sales_list_id']);
                }
            }
            $u = $_POST['sales_list_id'];
            $sales->update($_POST);
            redirection('/bankslip.php?id=' . ($u));
            //redirection('aaa.php');
        } else if ($_POST['form_action'] === 'delete') {
            $sales->delete($_POST['sales_list_id']);
        } else if ($_POST['form_action'] === 'insert') {
            if ($_FILES['import_files']['size'] > 0) {
                $path = './file/sales/sales_slip/';
                $filesname = uploadImage($_FILES['import_files'], "." . $path);
                if ($filesname) {
                    $_POST['import_files'] = $path . $filesname;
                } else {
                    $_POST['import_files'] = '';
                }
            } else {
                $_POST['import_files'] = '';
            }
            $sales->insert($_POST);
        }
    }
} else {
    echo "Page Not found.";
}
