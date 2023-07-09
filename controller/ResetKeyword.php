<?php
include_once '../database/Search.php';
include_once  './Redirection.php';
$searchP = new Search();
$searchP->reset();
redirection('../searchstatistics.php');
