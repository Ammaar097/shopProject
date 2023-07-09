<?php
include_once('../database/Employee.php');
if (isset($_GET['id'])) {
    $employee = new Employee();
    $rows = $employee->fetchById($_GET['id']);
    echo json_encode($rows);
} else {
    http_response_code(400);
}
