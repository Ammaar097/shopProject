<?php
include_once('../database/UserAccount.php');
if (!isset($_GET['type']) && (!isset($_GET['keyword']))) {
    $user = new UserAccount();
    $rows = $user->fetchAddEmployee();
    echo json_encode($rows);
} else if (isset($_GET['type']) && (!isset($_GET['keyword']))) {
    $user = new UserAccount();
    $rows = $user->findByType($_GET['type']);
    echo json_encode($rows);
} else if (!isset($_GET['type']) && (isset($_GET['keyword']))) {
    $user = new UserAccount();
    $rows = $user->search($_GET['keyword']);
    echo json_encode($rows);
} else if (isset($_GET['type']) && (isset($_GET['keyword']))) {
    $user = new UserAccount();
    $rows = $user->search($_GET['keyword'], $_GET['type']);
    echo json_encode($rows);
}
