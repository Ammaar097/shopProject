<?php
include_once '../database/Sales.php';
$sales = new Sales();
echo $sales->getLastId();
