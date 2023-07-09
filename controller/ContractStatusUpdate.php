<?php
include_once '../database/Contract.php';
$contract = new Contract();
$timeOut = $contract->getTimeOut();
foreach ($timeOut as $t){
    $contract->updatestatus(1, $t['contract_code']);
}
