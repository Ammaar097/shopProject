<?php
include_once ('./controller/Redirection.php');
if (!isset($_SESSION)) {
    session_start();
};

function isAdmin()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] != "A") {  //ถ้าไม่ใช่แอดมิน ให้ไปindex
        redirection('/index.php');
    } else if (!isset($_SESSION['role'])) {  //ถ้าไม่ได้ล็อกอิน ให้ไปcustomer
        redirection('/customer.php');
    }
}

function isNotAdmin(){
    if (isset($_SESSION['role']) && $_SESSION['role'] == "A") {  //ถ้าใช่แอดมิน ให้ไปindex
        redirection('/index.php');
    } else if (!isset($_SESSION['role'])) {  //ถ้าไม่ได้ล็อกอิน ให้ไปcustomer
        redirection('/customer.php');
    }
}


function isLaber()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] != "L") {  //ถ้าไม่ใช่แอดมิน ให้ไปindex
        redirection('/index.php');
    } else if (!isset($_SESSION['role'])) {  //ถ้าไม่ได้ล็อกอิน ให้ไปcustomer
        redirection('/customer.php');
    }
}

function isEmployee()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] != "E") {  //ถ้าไม่ใช่แอดมิน ให้ไปindex
        redirection('/index.php');
    } else if (!isset($_SESSION['role'])) {  //ถ้าไม่ได้ล็อกอิน ให้ไปcustomer
        redirection('/customer.php');
    }
}

function isLogin()
{
    if (!isset($_SESSION['role'])) {  //ถ้าไม่ได้ล็อกอิน ให้ไปcustomer
        redirection('/customer.php');
    }
}

function getRole()
{
    if (!isset($_SESSION['role'])) {
        redirection('/customer.php');
    } else {
        return $_SESSION['role'];
    }
}


function logout()
{

    if (!isset($_SESSION['vat'])) {
        $vat = 7;
    }else{
        $vat = $_SESSION['vat'];
    }
    if (!isset($_SESSION['day_change'])) {
        $day_change = 7;
    }else{
        $day_change = $_SESSION['day_change'];
    }
    if (!isset($_SESSION['shop_name'])) {
        $name = "วรเชษฐ์เกษตรภัณฑ์";
    }
    if (isset($_SESSION['shop_name'])) {
        $name = $_SESSION['shop_name'] ;
    }
    if (!isset($_SESSION['interest'])) {
        $interest  = 2;
    }
    if (!isset($_SESSION['interest_month'])) {
        $interest_month = 4;
    }
    if (isset($_SESSION['interest'])) {
        $interest  = $_SESSION['interest'];
    }
    if (isset($_SESSION['interest_month'])) {
        $interest_month = $_SESSION['interest_month'] ;
    }
    if (!isset($_SESSION['address'])) {
//        $_SESSION['address'] = 'xxxxxxxxx';
        $address = 'xxxxxxxxx';
    }
    else{
        $address = $_SESSION['address'];
    }
    if (!isset($_SESSION['vat_no'])) {
//        $_SESSION['vat_no'] = "xxxxxxxxxxxxx";
        $vat_no = "xxxxxxxxxxxxx";
    }
    else {
        $vat_no = $_SESSION['vat_no'];
    }
    if (!isset($_SESSION['tel'])) {
        $tel = "xxxxxxxx";
    }
    else {
        $tel = $_SESSION['tel'];
    }
    session_destroy();
    session_start();
    $_SESSION['vat']  = $vat;
    $_SESSION['day_change'] = $day_change;
    $_SESSION['tel'] = $tel;
    $_SESSION['vat_no'] = $vat_no;
    $_SESSION['address']= $address;
    $_SESSION['shop_name'] =$name;
    $_SESSION['interest'] = $interest;
    $_SESSION['interest_month'] = $interest_month;
}
