<?php
include_once '../database/Contract.php';
$contract = new Contract();
echo $contract->getLastId();
