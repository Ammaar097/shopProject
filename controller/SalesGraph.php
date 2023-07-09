<?php
include_once('../database/SalesGraph.php');
if (!isset($_GET['category_id']) && (!isset($_GET['date'])) && (!isset($_GET['limit']))) {
    $salesgraph = new SalesGraph();
    $rows = $salesgraph->fetchAll();
    echo json_encode($rows);
} else if (isset($_GET['category_id']) && (isset($_GET['date'])) && (isset($_GET['limit']))) {
    $salesgraph = new SalesGraph();
    $rows = $salesgraph->fetchAllDateAndId($_GET['date'], $_GET['category_id'], $_GET['limit']);
    echo json_encode($rows);
} else if (!isset($_GET['category_id']) && (isset($_GET['date'])) && (isset($_GET['limit']))) {
    $salesgraph = new SalesGraph();
    $rows = $salesgraph->fetchAllDate($_GET['date'], $_GET['limit']);
    echo json_encode($rows);
}
