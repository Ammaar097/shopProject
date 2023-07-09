<?php
include_once('../database/UserAccount.php');
if (isset($_GET['id'])) {
    $useraccount = new UserAccount();
    $rows = $useraccount->fetchById($_GET['id']);
    echo json_encode($rows);
} else {
    http_response_code(400);
}
