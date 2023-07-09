<?php
include_once '../database/UserAccount.php';
include_once 'Redirection.php';
$useraccount = new UserAccount();

if (isset($_POST)) {
    if ($_POST['table'] === 'useraccount') {
        if ($_POST['form_action'] === 'update') {
            $useraccount->update($_POST);
        } else if ($_POST['form_action'] === 'delete') {
            $useraccount->delete($_POST['unique_id']);
        } else if ($_POST['form_action'] === 'insert') {
            if (empty($_POST['account_user_status'])) {
                $_POST['account_user_status'] = '0';
            } else {
                $_POST['account_user_status'] = '1';
            }
            $_POST['account_password'] = password_hash($_POST['account_password'], PASSWORD_BCRYPT);  //ทำให้ไม่เห็นรหัสผ่าน
            $useraccount->insert($_POST);
        }
        redirection("/manageuseraccounts.php");
    }
} else {
    echo "Page Not found.";
}
