<?php
require_once '../vendor/autoload.php';
include_once '../../../database/Contract.php';
include_once '../../bahtText.php';
include_once '../../datetimeDisplay.php';
$Contract = new Contract();
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['shop_name'])) {
    $_SESSION['shop_name'] = "ร้านวรเชษฐ์เกษตรภัณฑ์";
}
if(!isset($_GET['id'])){
  echo "Not found.";
  exit();
}
$id = $_GET['id'];
$data = $Contract->fetchByPDFId($id);
if(count($data)<=0){
  echo "Not found.";
  exit();
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
<head>
<title>สัญญาซื้อขาย</title>
<style type="text/css">
.setcenter {
	text-align: center;
}
.setright {
	text-align: right;
}

.setleft {
	margin-left:80rem;
}
.smailfont{
  font-size: 3px !important;
}

h2{
  font-size: 55pt;
  }
  td{
  font-size: 50pt;
  }
</style>
</head>

<body>
<table  width="1000" border="0">
  <tr class="setcenter">
    <td colspan="2" class="setcenter"><h2>'.$_SESSION['shop_name'].'</h2></td>
  </tr>
  <tr class="setcenter" >
    <td colspan="2" class="setcenter"><h2>สัญญาซื้อขาย</h2></td>
  </tr>
  <tr>
    <td>ฉบับที่ : ' . $_GET['id'] . '</td>
    <td class="setright">วันที่ทำสัญญา : ' .toDay(). '</td>
  </tr>
  <tr>
    <td colspan="2">ข้าพเจ้า ' . $data['employee_prefix'] . $data['employee_firstname'] ."". $data['employee_lastname'] .' ซึ่งต่อไปในหนังสือสัญญานี้เรียกว่าผู้ขายฝ่ายหนึ่งกับ</td>
  </tr>
  <tr class="setcenter">
    <td colspan="2">
    <table border="0">
      <tr>
        <td width="800">ข้าพเจ้า : ' . $data['customer_prefix'] . $data['customer_firstname'] ."  ". $data['customer_lastname'] . '</td>
        <td width="800">รหัสบัตรประชาชน : ' . $data['customer_img'] . '</td>
      </tr>
      </table>
      </td>
     </tr>
     <tr>
    <td colspan="2">ซึ่งต่อไปในหนังสือสัญญานี้เรียกว่าผู้ซื้อฝ่ายหนึ่ง ทั้งสองฝ่ายตกลงทำสัญญาซื้อขายทรัพย์สินมีดังข้อความต่อไปนี้</td>
  <tr>
      <td colspan="2">ข้อ 1 ผู้ขายได้ขาย : ' . $data['product_detail'] . '</td>
  </tr>
  <tr>
      <td colspan="2">ให้แก่ผู้ซื้อเป็นจำนวนเงิน ' . $data['baht'] . ' บาท ' . $data['stang'] . ' สตางค์ (&nbsp;' . $data['stangt'] . '&nbsp;)</td>
  </tr>
  <tr>
      <td colspan="2" width="2300">และยอมส่งมอบทรัพย์สินที่ขายให้แก่ผู้ซื้อวันที่ ' . dateTimeDisplay($data['date_send']) . ' และผู้ขายได้รับราคาดังกล่าวแล้วไปจากผู้ซื้อเสร็จแล้วตั้งแต่วันที่ ' . dateTimeDisplay($data['price_send']) . ' </td>
  </tr>
  <tr>
  <td colspan="2">ข้อ 2 ผู้ขายยอมสัญญาว่าทรัพย์สินซ่งผู้ขายนำมาขายให้แก่ผู้ซื้อนี้เป็นทรัพย์สินของผู้ขายคนเดียว และไม่เคยนำไปขาย จำนำ หรือทำสัญญาผูกพันธ์ใด ๆ แก่ผู้ใดเลย
  </td>
  </tr>
  <tr>
      <td colspan="2">ข้อ 3 : ' . $data['contract_details'] . '</td>
  </tr>
<tr>
      <td colspan="2">ข้อ 4 ผู้ขายและผู้ซื้อได้ทราบข้อความในสัญญานี้ดีแล้ว จึงได้ลงลายมือชื่อไว้ในสัญญานี้เป็นหลักฐาน</td>
  </tr>
  <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>


<table width="0" border="0">
<tr class="setcenter">
<td width="1500" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">พยานคนที่ 1 </td>
</tr>
<tr class="setcenter">
<td width="1500" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">.....................................................</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
<tr class="setcenter">
<td width="1000"  class="smailfont">&nbsp; </td>
<td width="800" class="smailfont">&nbsp;</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">พยานคนที่ 2 </td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">.....................................................</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
<tr class="setcenter">
<td width="1000" class="smailfont">&nbsp; </td>
<td width="800" class="smailfont">&nbsp;</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">พยานคนที่ 3 </td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">.....................................................</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
</tr>
<tr class="setcenter">
<td width="1000" class="smailfont">&nbsp; </td>
<td width="800" class="smailfont">&nbsp;</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">ผู้ซื้อ</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">.....................................................</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">(&nbsp;' . $data['customer_prefix'] . $data['customer_firstname'] ."  ". $data['customer_lastname'] . '&nbsp;)</td>
</tr>
<tr class="setcenter">
<td width="1000" class="smailfont">&nbsp; </td>
<td width="800" class="smailfont">&nbsp;</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">ผู้ขาย </td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">.....................................................</td>
</tr>
<tr class="setcenter">
<td width="1000" class="setcenter">&nbsp; </td>
<td width="800" class="setcenter">(&nbsp;'.$data['employee_prefix'] . $data['employee_firstname'] ."&nbsp;". $data['employee_lastname'].'&nbsp;)</td>
</tr>
</table>

  
     <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
  <tr>
      <td colspan="2">1.หากผู้ขายยังไม่ได้ส่งมอบทรัพย์ให้ในเวลาทำสัญญาควรจะเติมข้อความอีก 1 ข้อว่าตราบใดที่ผู้ขายยังไม่ส่งมอบทรัพย์ให้ ยังไม่ถือว่าได้มีการซื้อขาย มิฉะนั้นผู้ซื้ออาจเสียเปรียบผู้ขาย</td>
  </tr> 
  <tr>
      <td colspan="2">2. สัญญาซื้อขายไม่ต้องปิดอากรแสตมป์ เว้นแต่จะถือว่าสัญญานี้เป็นใบรับเงินแล้ว ถ้าสัญญาซื้อขายนี้ตั้งแต่ 10 บาท ถึง 20 บาท ต้องติดอากรแสตมป์ 10 สตางค์ ถ้าสัญญาซื้ขายนี้เกิน 20 บาท ทุก 20 บาท หรือเศษของ 20 บาท ต่อ 10 สตางค์ ถ้าสัญญาซื้อขายต่ำกว่า 10 บาท ไม่ต้องติดอากรแสตมป์</td>
  </tr>

</table>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output($output, 'I');
