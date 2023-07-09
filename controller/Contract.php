<?php
include_once '../database/Contract.php';
include_once 'Redirection.php';
include_once '../service/upload.php';
$contract = new Contract();
if (isset($_POST)) {
    if ($_POST['table'] == 'contract') {
        if ($_POST['form_action'] === 'update') {
            $contract->update($_POST);
            redirection('/contracthistory.php');
        } else if ($_POST['form_action'] === 'delete') {
            $contract->delete($_POST['contract_code']);
        } else if ($_POST['form_action'] === 'insert') {
            $contract->insert($_POST);
            redirection('/contracthistory.php');
        } else if ($_POST['form_action'] == 'upload') {
            if ($_FILES['contract_attachment']['size'] > 0) {
                $path = './file/contract/id/' . $_POST['contract_code'] . '/';
                $filesname = uploadImage($_FILES['contract_attachment'], "." . $path);
                if ($filesname) {
                    $_POST['contract_attachment'] = $path . $filesname;
                } else {
                    $_POST['contract_attachment'] = '';
                }
            } else {
                $_POST['contract_attachment'] = '';
            }
            $contract->upload($_POST);
            redirection('/contracthistory.php');
        } else if ($_POST['form_action'] == 'push') {
            $contract->push($_POST['q'], $_POST['contract_code']);
        } else if ($_POST['form_action'] == 'updateremain') {
            $contract->updateremain($_POST['outstanding'], $_POST['contract_code']);
        } else if ($_POST['form_action'] == 'updatestatus') {
            $contract->updatestatus($_POST['promise_status'], $_POST['contract_code']);
        }
    }
} else {
    echo "Page Not found.";
}
