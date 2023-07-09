<?php
echo "<meta charset='utf-8'>";
function ThDate($inputdate)
{

//เดือนภาษาไทย
$ThMonth = array ( "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค." );
 
//กำหนดคุณสมบัติ
$week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
$months = substr($inputdate,5,2)-1; // ค่าเดือน (1-12)
$day = substr($inputdate,8,2 ); // ค่าวันที่(1-31)
$years = substr( $inputdate,0,4 )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.
 
return "$day  
		$ThMonth[$months] 
		$years";
}
$inputdate= "2022-12-30";
echo ThDate($inputdate); // แสดงวันที่ 
