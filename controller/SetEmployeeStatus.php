<?php
include_once '../database/Employee.php';
$employee = new Employee();
if (isset($_GET['status']) && (isset($_GET['id']))) {
    $employee->updateStatus($_GET['status'] == 'true' ? 1 : 0, $_GET['id']);
} else {
    echo "Page Not found.";
}
