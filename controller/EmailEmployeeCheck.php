<?php
include_once '../database/Employee.php';
$employee = new Employee();
if ($_GET['email']) {
    echo json_encode($employee->emailCheck($_GET['email']));
} else {
    echo "Page Not found.";
}
