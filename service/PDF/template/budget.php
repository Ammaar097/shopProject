<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['shop_name'])) {
  $_SESSION['shop_name'] = "ร้านวรเชษฐ์เกษตรภัณฑ์";
}
require_once '../vendor/autoload.php';
if (!isset($_POST['complete']) || !isset($_POST['cash']) || !isset($_POST['cash2']) || !isset($_POST['credit2']) || !isset($_POST['credit']) || !isset($_POST['DB']) || !isset($_POST['BG1']) || !isset($_POST['BG2']) || !isset($_POST['BG3']) || !isset($_POST['firstdate']) || !isset($_POST['lastdate'])) {
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


include_once('../budget.php');
include_once '../../datetimeDisplay.php';
$html = '<html>
<head>
<style type="text/css">
.setcenter {
	text-align: center;
}
.setright {
	text-align: right;
}
.l {
	background-color: #ABBE99;
	padding-top: 10px;
	padding-bottom: 10px;
}
.line {
	height: 1pt;
	width: 1200px;
	background-color: #000
}
.a {
	float: left;
	width: 50%;
}
.grey {
	background-color: #FBEDD8;
	width: 100%;
	float: left;
}

.grey2 {
	background-color: #FFF8ED;
	width: 100%;
	float: left;
}

.t {
	color: #A36627;
	font-size: 55pt;
}
table{
border-spacing: 0px;
}
td{
	font-size:40pt;
	}
tr{
border: 0px;
}
.t {
	padding-top: 10px;
	padding-bottom: 10px;
}
.left{
	margin-left :1rem;
	}
.right{
	margin-right :1rem;
	}

.st{
  font-size:30pt;
}
</style>
</head>

<body>
<table width="1000" border="0px" border="">
  <tr>
    <td class="setright st" colspan="3">วันที่ออกเอกสาร ' . toDay() . '</td>
  </tr>
  <tr>
    <td class="setcenter" colspan="3"><h2>งบแสดงฐานะการเงิน</h2></td>
  </tr>
  <tr>
    <td class="setcenter" colspan="3">
      <h2 >' . $_SESSION['shop_name'] . '</h2>
      </td>
  </tr>
  <tr>
  <tr>
    <td class="setcenter"  colspan="3">วันที่ ' . dateTimeDisplay($_POST['firstdate']) . ' - ' . dateTimeDisplay($_POST['lastdate']) . '</td>
  </tr>
  </tr>
  <tr>
    <td class="t" >&nbsp;&nbsp;สินทรัพย์</td>
  </tr>
  <tr bgcolor="#FBEDD8">
    <td width="70%" stlye="">รวม สินทรัพย์</div>
    <td align="right" width="20%">' . number_format(($_POST['BG1'] + ($_POST['cash2']) + abs($_POST['DB'])), 2) . '</td>
    <td width="20%">บาท</td>
  </tr>
  <tr bgcolor="#FFF8ED">
  <td width="70%" stlye="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สินค้าที่พร้อมขาย</div>
  <td align="right" width="20%">' . number_format($_POST['BG1'], 2) . '</td>
  <td width="20%">บาท</td>
</tr>
<tr bgcolor="#FBEDD8">
  <td width="70%" stlye="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เงินที่ได้รับแล้ว</div>
  <td align="right" width="20%">' . number_format(($_POST['cash2'] + $_POST['DB']), 2) . '</td>
  <td width="20%">บาท</td>
</tr>
<tr bgcolor="#FFF8ED">
<td width="70%" stlye="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เงินที่ยังไม่ได้รับ</div>
<td align="right" width="20%">' . number_format(($_POST['credit2'] - $_POST['DB']), 2) . '</td>
<td width="20%">บาท</td>
</tr>

<tr>
<td>&nbsp;</td>
</tr>
  <tr>
    <td class="t">&nbsp;&nbsp;หนี้สิน+ทุน</td>
  </tr>
  <tr  bgcolor="#FBEDD8">
    <td  width="70%">รวม หนี้สิน+ทุน &nbsp;</td>
    <td align="right" width="20%">' . number_format($_POST['BG3'], 2) . '</td>
    <td width="20%">บาท</td>
  </tr>
  <tr bgcolor="#FFF8ED">
<td width="70%" stlye="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ทุน </div>
<td align="right" width="20%">' . number_format($_POST['complete'], 2) . '</td>
<td width="20%">บาท</td>
</tr>
<tr bgcolor="#FBEDD8">
<td width="70%" stlye="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หนี้สิน(เงินสด)   </div>
<td align="right" width="20%">' . number_format($_POST['cash'], 2) . '</td>
<td width="20%">บาท</td>
</tr>
<tr bgcolor="#FFF8ED">
<td width="70%" stlye="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; หนี้สิน(เครดิต)  </div>
<td align="right" width="20%">' . number_format($_POST['credit'], 2) . '</td>
<td width="20%">บาท</td>
</tr>
</table>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output($output, 'I');


?>
<script src="..../src/js/budget.js"></script>