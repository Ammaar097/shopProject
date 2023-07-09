<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_POST['table'] = 'useraccount';
$_POST['form_action'] = 'login'; 
$_POST['email'] = 'vitoon.1405@hotmail.com' ;
$_POST['password'] = '0987654321' ;
$_POST['btLogin_click()'] = 'login' ;

print_r($_POST);

include_once 'Redirection.php';
//include_once '../database/UserAccount.php';
include_once '../database/Employee.php';



//$useraccount = new UserAccount();
$employee = new Employee();



?>