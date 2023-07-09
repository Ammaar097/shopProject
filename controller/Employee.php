<?php
include_once '../database/Employee.php';
include_once '../service/upload.php';
include_once '../database/EmployeeBank.php';
include_once 'Redirection.php';
$employeebank = new EmployeeBank();
$employee = new Employee();
if (isset($_POST)) {
    if ($_POST['table'] === 'employee') {
        if ($_POST['form_action'] === 'update') {
            if ($_FILES['employee_card_id_copy']['size'] > 0) {
                $path = './file/employee/id/';
                if (file_exists($_POST['employee_card_id_copy'])) {
                    unlink($_POST['employee_card_id_copy']);
                }
                $filesname = $path . uploadImage($_FILES['employee_card_id_copy'], "." . $path);
                if ($filesname) {
                    $employee->updateimage('employee_card_id_copy',$filesname,$_POST['employee_id']);
                }
            }
            if ($_FILES['employee_address_copy']['size'] > 0) {
                $path = './file/employee/address/';
                if (file_exists($_POST['employee_address_copy'])) {
                    unlink($_POST['employee_address_copy']);
                }
                $filesname = $path . uploadImage($_FILES['employee_address_copy'], "." . $path);
                if ($filesname) {
                    $employee->updateimage('employee_address_copy',$filesname,$_POST['employee_id']);
                }
            }

            $banks = json_decode($_POST['bank']);
            $tempbanks = [];
            foreach ($banks as $b) {
                $tempbanks[] = (array)$b;
            }
            $banks = $tempbanks;
            // remove bank and edit
            $recBack = $employeebank->fetchByEmployeeId($_POST['employee_id']);
            foreach ($recBack as $r) {
                $f = false;
                foreach ($banks as $value) {
                    $f = $f  || ($r['bank_id'] == $value['id']);
                }
                if (!$f) {
                    $employeebank->delete($r['bank_id']);
                } else {
                    $form = [];
                    $form['bank_id'] =  $r['bank_id'];
                    $form['employee_id'] =  $_POST['employee_id'];
                    $form['bank_name'] = $value['bank'];
                    $form['bank_number'] =  $value['number'];
                    $form['bank_account'] =  $value['name'];
                    $employeebank->update($form);
                }
            }
            // insert bank to edit
            foreach ($banks as $value) {
                if ($value['id'] == -1) {
                    $form = [];
                    $form['employee_id'] =  $_POST['employee_id'];
                    $form['bank_name'] = $value['bank'];
                    $form['bank_number'] =  $value['number'];
                    $form['bank_account'] =  $value['name'];
                    $employeebank->insert($form);
                }
            }
            $employee->update($_POST);
            Redirection("/employee.php");
        }
        else if ($_POST['form_action'] === 'delete') {  //ลบข้อมูลของพนักงาน
            if (file_exists($_POST['employee_card_id_copy'])) {
                unlink($_POST['employee_card_id_copy']);
            }
            if (file_exists($_POST['employee_address_copy'])) {
                unlink($_POST['employee_address_copy']);
            }
            $employeebank->deleteByEmployeeId($_POST['employee_id']);
            $employee->delete($_POST['employee_id']);
            Redirection("/employee.php");
        }
        else if ($_POST['form_action'] === 'insert') {
            //อัพโหลด
            if (isset($_FILES['employee_card_id_copy'])) {
                $path = './file/employee/id/';
                $filesname = uploadImage($_FILES['employee_card_id_copy'], "." . $path);
                if ($filesname) {
                    $_POST['employee_card_id_copy'] = $path . $filesname;
                } else {
                    $_POST['employee_card_id_copy'] = '';
                }
            } else {
                $_POST['employee_card_id_copy'] = '';
            }

            if (isset($_FILES['employee_address_copy'])) {
                $path = './file/employee/address/';
                $filesname = uploadImage($_FILES['employee_address_copy'], "." . $path);
                if ($filesname) {
                    $_POST['employee_address_copy'] = $path . $filesname;
                } else {
                    $_POST['employee_address_copy'] = '';
                }
            } else {
                $_POST['employee_address_copy'] = '';
            }
            $_POST['employee_card_id'] = str_replace("-", "", $_POST['employee_card_id']);
            $_POST['employee_telephone'] = str_replace("-", "", $_POST['employee_telephone']);
            $employee->insert($_POST);
            $last = $employee->fetchLast();
            $lastID = $last['employee_id'];
            $banks = json_decode($_POST['bank']);
            foreach ($banks as $value) {
                $form = [];
                $form['employee_id'] =  $lastID;
                $form['bank_name'] = $value->bank;
                $form['bank_number'] =  $value->number;
                $form['bank_account'] =  $value->name;
                $employeebank->insert($form);
            }
            $employee->insert($_POST);
            Redirection("/employee.php");

        }
    }
} else {
    echo "Page Not found.";
}
