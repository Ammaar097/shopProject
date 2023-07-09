<?php

require_once '../vendor/autoload.php';
require_once '../../../database/Order.php';
require_once '../../../database/OtherPrice.php';
require_once '../../../database/Product.php';
include_once '../../datetimeDisplay.php';
$Order = new Order();
$otherPrice = new OtherPrice();
$product = new Product();
if (!isset($_GET['id'])) {
    echo "Not found.";
    exit();
}
$id = $_GET['id'];
$data = $Order->fetchAllOrder($id);
$data1 = $otherPrice->fetchByOPId($id);

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
    'debug'=>false,

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
$list1 = "";
$list2 = "";
$AllPrice = 0;
$c = 1;
foreach ($data as $d) {
    $p = $product->fetchById($d['product_id']);
    $list1 .= '<tr>
          <td>' . $c . '</td>
          <td>' . $p['product_name'] . '</td>
          <td>' . number_format($d['order_pr'],2) . '</td>
          <td>' . number_format($d['order_amt']) . '</td>
          <td>'.number_format($d['order_pr']*$d['order_amt'],2).'</td></tr>';

    $AllPrice+=$d['order_pr']*$d['order_amt'];
    $c++;
}
$c = 1;
foreach ($data1 as $d) {
    $list2 .= '<tr>
        <td>' . $c . '</td>
        <td>' . $d['listother'] . '</td>
        <td>' . number_format($d['priceother'],2) . '</td>
      </tr>';
    $AllPrice+=$d['priceother'];
    $c++;
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
font-size: 36pt;
}
td{
font-size: 28pt;
}
</style>
</head>

<body>
<table  width="1000" border="0">
  <tr >
    <td colspan="2" class="setcenter"><h2>'.$_SESSION['shop_name'].'</h2></td>
  </tr>
  <tr >
    <td colspan="2" class="setcenter"><h2 >ใบสั่งซื้อ</h2></td>
  </tr>
  <tr>
    <td>วันที่วางบิล :&nbsp;' . dateTimeDisplay($data[0]['datebill'] ). '</td>
    <td class="setright">วันที่รับของ : ' .dateTimeDisplay($data[0]['datereceive']). '</td>
  </tr>
  <tr>
    <td colspan="2">ชื่อผู้ขาย : ' . $data[0] ['sell_name']. '</td>
  </tr>
  <tr>
    <td>วิธีการชำระเงิน : ' . $data[0]['payment_sl'] . '</td>
    <td class="setright">วันที่ชำระเงิน : ' . dateTimeDisplay($data[0]['payment_dt'] ).'</td>
  </tr>
  <tr>
    <td colspan="2">หมายเหตุ : ' . $data[0]['note'] . '</td>
  </tr>
  <br>
  <tr>
    <td colspan="2" class="setcenter"><h3>รายการสินค้า</h3><br>
      <table width="1000" border="1">
        <tr>
        <td width="100">ลำดับ</td>
          <td width="450">รายการสินค้า</td>
          <td width="200">ราคาต่อหน่วย (บาท)</td>
          <td width="120">จำนวน</td>
          <td width="200">ราคา (บาท)</td>
        </tr>
        ' . $list1 . '
      </table>
    </td>
  </tr>
  <br>
  <tr>
    <td colspan="2" class="setcenter"><h3>ค่าใช้จ่ายอื่นๆ</h3><br>
    <table width="1000" border="1">
      <tr>
      <td width="100">ลำดับ</td>
        <td width="454">รายการ</td>
        <td width="530">ราคา</td>
      </tr>
      ' . $list2 . '
    </table>
    </td>
  </tr>
  <br>
  <tr>
    <td colspan="2" class="setright">ยอดสุทธิ : ' . number_format($AllPrice,2) . '</td>
  </tr>
</table>
</body>
</html>
';


$mpdf->WriteHTML($html);
$mpdf->Output($output, 'I');
