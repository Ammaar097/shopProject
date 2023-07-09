<?php
require_once '../../../database/DailyBestSeller.php';
require_once '../../../database/Sales.php';
require_once '../../bahtText.php';
require_once '../vendor/autoload.php';
require_once '../../../controller/Redirection.php';
include_once '../../datetimeDisplay.php';
if (!isset($_GET['id'])) {
  echo "Not found.";
  exit;
}
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['shop_name'])) {
  $_SESSION['shop_name'] = "ร้านวรเชษฐ์เกษตรภัณฑ์";
}
if (!isset($_SESSION['address'])) {
  $_SESSION['address'] = 'xxxxxxxxx';
}
if (!isset($_SESSION['vat_no'])) {
  $_SESSION['vat_no'] = "xxxxxxxxxxxxx";
}
if (!isset($_SESSION['tel'])) {
  $_SESSION['tel'] = "xxxxxxxx";
}
$d = new DailyBestSeller();
$data = $d->fetchBySalesListId($_GET['id']);
$sd = new Sales();
$data2 = $sd->fetchBySalesListId($_GET['id']);
if (count($data) <= 0) {
  echo "Not found.";
  exit;
}
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8',
  'format' => 'A4',
  'margin_left' => 15,
  'margin_right' => 15,
  'margin_top' => 16,
  'margin_bottom' => 16,
  'margin_header' => 9,
  'margin_footer' => 9,
  'mirrorMargins' => true,

  'fontDir' => array_merge($fontDirs, [
    '../vendor/mpdf/mpdf/custom/font/directory',
  ]),
  'fontdata' => $fontData + [
    'thsarabun' => [
      'R' => 'THSarabunNew.ttf',
      'I' => 'THSarabunNew Italic.ttf',
      'B' => 'THSarabunNew Bold.ttf',
      'U' => 'THSarabunNew BoldItalic.ttf'
    ]
  ],
  'default_font' => 'thsarabun',
  'defaultPageNumStyle' => 1
]);


$r = '';
$c = 1;
$p = 0;
foreach ($data as $row) {
  $r .= '<tr>
  <td width="140" class="setcenter">' . $c . '</td>
  <td width="426">&nbsp; ' . $row['product_name'] . '</td>
  <td width="162" class="setcenter">' . number_format($row['sales_amt']) . '</td>
  <td width="304" class="setright"> ' . number_format($row['price'], 2) . ' &nbsp;</td>
  <td width="238" class="setright"> ' . number_format($row['price'] * $row['sales_amt'], 2) . ' &nbsp;</td>
</tr>';
  $c++;
  $p += $row['price'] * $row['sales_amt'];
}
$html = '<html>
<head>
<style type="text/css">
.setcenter {
	text-align: center;
}
.setright {
	text-align: right;
}
h2{
  font-size: 55pt;
  }
  td{
  font-size: 40pt;
  }
</style>
</head>

<body>
<table  width="1000" border="0">
<tr>
<td height="41" colspan="2" class="setcenter"><h2>' . $_SESSION['shop_name'] . '</h2></td>
</tr>
<tr class="setcenter">
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td height="21" colspan="2" class="setcenter">ที่อยู่ : ' . $_SESSION['address'] . '
</td>
</tr>
<tr>
<td colspan="2" class="setcenter">เลขประจำตัวผู้เสียภาษี : ' . $_SESSION['vat_no'] . ' </td>
</tr>
<tr>
<td colspan="2" class="setcenter">เบอร์โทรติดต่อ : ' . $_SESSION['tel'] . '</td>
</tr>
<tr class="setcenter">
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2" class="setcenter"><h2>ใบเสร็จรับเงิน</h2></td>
</tr>
  <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
 <tr class="setcenter">
 <td>
 <table width="1138" border="0">
      <tr>
        <td>ฉบับที่ : ' . $_GET['id'] . '</td>
        <td>&nbsp;&nbsp;วันที่ : ' . dateTimeDisplay($data2['payment_dt']) . '</td>
        <td>&nbsp;&nbsp;เวลา : ' . ShowTime2($data2['payment_dt']) . '&nbsp;น.</td> 
      </tr>
    </table>
    </td>
  </tr>
   <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
<tr class="setcenter">
 <td>
    <table width="1148" border="1">
    <tr class="setcenter">
    <td width="316" class="setcenter">ลำดับ </td>
    <td width="283" class="setcenter">รายละเอียด</td>
    <td width="118" class="setcenter">จำนวน </td>
    <td width="121" class="setcenter">หน่วยละ </td>
    <td width="128" class="setcenter">จำนวนเงิน </td>
  </tr>
      </tr>
      ' . $r . '
      <tr>
      <td  colspan="3">วิธีการชำระเงิน : '.$data2['payment_sl'].' </td>
      <td width="304" class="setright">ยอดรวมสุทธิ : &nbsp;</td>
      <td width="238" class="setright">' . number_format($p, 2) . ' &nbsp;</td>
    </tr>
   </table>
      </td>
   </tr>
   
   </table>
   <br>
   <div class="setright" style="font-size:20pt;">
    ' . bahtText($p) . ' &nbsp;
  </div>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output($output, 'I');
