<?php
include_once '../database/Search_Category.php';
include_once './Redirection.php';
$searchC = new Search_Category();
$searchC->reset();
redirection('../productsearchstatistics.php');
