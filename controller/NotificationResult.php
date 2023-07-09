<?php
include_once('../database/Notification.php');
//กรณีที่ 1 ถ้าไม่ค้นหาทั้งจาก keyword และ ตัวเลือกประเภทสินค้า จะโชว์ทั้งหมด
if (!isset($_GET['category_id']) && (!isset($_GET['keyword']))) {
    $n = new Notification();
    $rows = $n->fetchAddCategory();
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (!isset($_GET['keyword']))) {
    $n = new Notification();
    $rows = $n->fetchByCategoryId($_GET['category_id']);
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (isset($_GET['keyword']))) {
    $n = new Notification();
    $rows = $n->search($_GET['keyword']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (isset($_GET['keyword']))) {
    $n = new Notification();
    $rows = $n->search($_GET['keyword'], $_GET['category_id']);
    echo json_encode($rows);
}
