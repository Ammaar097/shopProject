<?php
include_once('../database/DailyBestSeller.php');
if (!isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->fetchAll();
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->fetchAllDate($_GET['date']);
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->searchsales($_GET['keyword']);
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->fetchAllDateAndKeyword($_GET['date'], $_GET['keyword']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->fetchById($_GET['category_id']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (!isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->fetchAllDateAndId($_GET['date'], $_GET['category_id']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (isset($_GET['keyword'])) && (!isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->searchsales($_GET['keyword'], $_GET['category_id']);
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (isset($_GET['keyword'])) && (isset($_GET['date']))) {
    $sales = new DailyBestSeller();
    $rows = $sales->fetchAllCondition($_GET['date'], $_GET['category_id'], $_GET['keyword']);
    echo json_encode($rows);
}
