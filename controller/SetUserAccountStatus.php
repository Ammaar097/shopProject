<?php
include_once '../database/UserAccount.php';
$useraccount = new UserAccount();
if (isset($_GET['status']) && (isset($_GET['id']))) {
    $useraccount->updateStatus($_GET['status'] == 'true' ? 1 : 0, $_GET['id']);
} else {
    echo "Page Not found.";
}
