<?php
require_once '../vendor/autoload.php';
include_once '../../../database/Sales.php';
include_once '../../../database/SalesDetails.php';
include_once '../../bahtText.php';
include_once '../../datetimeDisplay.php';
$sales = new Sales();
$salesDetail = new SalesDetails();
if (!isset($_GET['id'])) {
  echo "Not found.";
  exit();
}
$id = $_GET['id'];
$data = $sales->fetchByPDFId($id);

if (count($data) <= 0) {
  echo "Not found.";
  exit();
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
$detail = $salesDetail->fetchBySalesId($data['sales_list_id']);
$list1 = '';
$c = 1;
$p = 0;
foreach ($detail as $de) {
  $list1 .= '<tr>
        <td width="140" class="setcenter">' . $c . '</td>
        <td width="517">&nbsp;   ' . $de['product_name'] . '</td>
        <td width="162" class="setcenter"> ' . number_format($de['sales_amt']) . '</td>
        <td width="290" class="setright"> ' . number_format($de['price'], 2) . '&nbsp;&nbsp;</td>
        <td width="290" class="setright"> ' . number_format($de['sales_pr'], 2) . '&nbsp;&nbsp;</td>
      </tr>';
  $c++;
  $p += $de['price'] * $de['sales_amt'];
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

include_once "../PDF.php";
$html = '<html>
<link rel="shortcut icon" href="./src/images/892917.ico"/>
<head>
<link rel="shortcut icon" href="./src/images/892917.ico"/>
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
    <title>ใบส่งของ</title>
</head>
<link rel="shortcut icon" href="./src/images/892917.ico"/>

<body>
<table  width="1000" border="0">
  <tr class="setcenter">
    <td height="41" colspan="2" class="setcenter"><h2>' . $_SESSION['shop_name'] . '</h2></td>
</tr>
<tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
   <tr class="setcenter">
    <td height="21" colspan="2" class="setcenter">ที่อยู่ : ' . $_SESSION['address'] . '
</td>
  </tr>
   <tr class="setcenter">
    <td colspan="2" class="setcenter">เลขประจำตัวผู้เสียภาษี : ' . $_SESSION['vat_no'] . ' </td>
  </tr>
   <tr class="setcenter">
    <td colspan="2" class="setcenter">เบอร์โทรติดต่อ : ' . $_SESSION['tel'] . '</td>
  </tr>
  <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
  <tr class="setcenter">
    <td colspan="2" class="setcenter"><h2>ใบส่งของ</h2></td>
  </tr>
  <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
<tr class="setcenter">
<td>
<table width="1373" border="0">
<tr>
  <td width="597">ลูกค้า : ' . $data['customer_prefix'] . $data['customer_firstname'] . "  " . $data['customer_lastname'] . ' </td>
  <td width="502">เล่มที่ : ' . $data['contract_code'] . ' </td>
</tr>
<tr>
  <td>วันที่ : ' . dateTimeDisplay($data['price_send']) . '</td>
  <td>เวลา : ' . ShowTime2($data['price_send']) . '&nbsp;น.</td>
</tr>
</table>
   </td>
 </tr>
   <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
<tr class="setcenter">
 <td>
 <table width="1381" border="1">
      <tr class="setcenter">
        <td width="140" class="setcenter">ลำดับ </td>
        <td width="517" class="setcenter">รายละเอียด</td>
        <td width="162" class="setcenter">จำนวน </td>
        <td width="290" class="setcenter">หน่วยละ </td>
        <td width="238" class="setcenter">จำนวนเงิน </td>
      </tr>
      ' . $list1 . '
      <tr>
        <td  colspan="3">วิธีการชำระเงิน : ผ่อนชำระ </td>
        <td width="290" class="setright">ยอดรวมสุทธิ :  &nbsp;</td>
        <td width="238" class="setright">' . number_format($p, 2) . ' &nbsp;</td>
      </tr>
    </table>
   </td>
</tr>

  <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>
<table width="1000" border="0">
<tr class="setcenter">
<td>ลงชื่อ&nbsp;..................................................&nbsp;ผู้ส่งของ</td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
<td>ลงชื่อ&nbsp;..................................................&nbsp;ผู้รับของ</td>
</tr>
<tr class="setcenter">
<td class="setcenter">( ' . $data['employee_prefix'] . $data['employee_firstname'] . "&nbsp;" . $data['employee_lastname'] . ' )</td>
<td>&nbsp; </td>
<td class="setcenter">( ' . $data['customer_prefix'] . $data['customer_firstname'] . "  " . $data['customer_lastname'] . ' )</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output($output, 'I');
