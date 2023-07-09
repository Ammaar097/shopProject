<?php
function dateFormat($date)
{
    $monthTH_brev = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    $d = explode(" ", $date)[0];
    $day = intval(explode('-', $d)[2]);
    $month = $monthTH_brev[intval(explode('-', $d)[1]) - 1];
    $year = explode('-', $d)[0] + 543;
    return $day . " " . $month . " " . $year . " " . (explode(" ", $date)[1]);
}
