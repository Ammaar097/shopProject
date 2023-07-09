<?php
include_once 'database/AddtoCart.php';
$addtocart = new AddtoCart();
if($_GET['email']){
    echo json_encode($addtocart->emailCheck($_GET['email']));
}else {
    echo "Page Not found.";
}
