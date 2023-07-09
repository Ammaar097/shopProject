<?php
include_once('../database/Stock.php');
//กรณีที่ 1 ถ้าไม่ค้นหาทั้งจาก keyword และ ตัวเลือกประเภทสินค้า จะโชว์ทั้งหมด
if (!isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->fetchAll();
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->fetchAllDate($_GET['date']);
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->searchsales($_GET['keyword']);
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->fetchAllDateAndKeyword($_GET['date'], $_GET['keyword']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->fetchById($_GET['category_id']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->fetchAllDateAndId($_GET['date'], $_GET['category_id']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->searchsales($_GET['keyword'], $_GET['category_id']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $stock = new Stock();
    $rows = $stock->fetchAllCondition($_GET['date'], $_GET['category_id'], $_GET['keyword']);
    echo json_encode($rows);
}
