<?php
include_once('./database/Order.php');
function getdata()
{
    $order = new Order();
    if ((!isset($_GET['date']) && (!isset($_GET['keyword']))) || ($_GET['date'] == "" && $_GET['keyword'] == "")) {
        $rows = $order->fetchAllSell2();
    } else if ((isset($_GET['date']) && $_GET['date'] != "") && (!isset($_GET['keyword']) || $_GET['keyword'] == "")) {
        $rows = $order->fetchByDate2($_GET['date']);
    } else if ((!isset($_GET['date']) || $_GET['date'] == "") && (isset($_GET['keyword']) && $_GET['keyword'] != "")) {
        $rows = $order->search2($_GET['keyword']);
    } else if ((isset($_GET['date']) && $_GET['date'] != "") && (isset($_GET['keyword']) && $_GET['keyword'] != "")) {
        $rows = $order->search2($_GET['keyword'],);
    }
    return $rows;
}
