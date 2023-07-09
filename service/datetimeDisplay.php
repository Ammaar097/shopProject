<?php
function dateTimeDisplay($strDateTime)
{
    $moth = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $date = explode(' ', $strDateTime)[0];
    $D = array_reverse(explode('-', $date));
    $D[2] += 543;
    $D[1] = $moth[$D[1] - 1];
    return implode(' ', $D);
}

function toDay()
{
    $strDateTime = date('Y-m-d H:i');
    $moth = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
    $date = explode(' ', $strDateTime)[0];
    $D = array_reverse(explode('-', $date));
    $D[2] += 543;
    $D[1] = $moth[$D[1] - 1];
    return implode(' ', $D);
}

function ShowTime($strDateTime)
{
    return $date = explode(' ', $strDateTime)[1];
}

function ShowTime2()
{
    $strDateTime = date('Y-m-d H:i');
    return $date = explode(' ', $strDateTime)[1];
}
