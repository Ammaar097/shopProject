<?php

require_once '../vendor/autoload.php';
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
    <td colspan="2" class="setright">1/2 &nbsp;&nbsp;</td>
</tr>
  <tr>
    <td height="41" colspan="2" class="setcenter"><h2>ร้านวรเชษฐ์เกษตรภัณฑ์</h2></td>
</tr>
  <tr class="setcenter">
    <td colspan="2" class="setcenter"><h2>ใบเสร็จรับเงิน</h2></td>
  </tr>
  <tr class="setcenter">
    <td colspan="2">&nbsp;</td>
</tr>
<tr class="setcenter">
 <td>
 <table width="1304" border="1">
 <tr class="setcenter">
   <td width="140" class="setcenter">ลำดับ </td>
   <td width="426" class="setcenter">รายละเอียด</td>
   <td width="162" class="setcenter">จำนวน </td>
   <td width="304" class="setcenter">หน่วยละ </td>
   <td width="238" class="setcenter">จำนวนเงิน </td>
 </tr>
 <tr>
 <td width="140" class="setcenter"> 1</td>
 <td width="426">&nbsp; ใบตัดหญ้า</td>
 <td width="162" class="setcenter"> 3</td>
 <td width="304" class="setright"> 150 &nbsp;</td>
 <td width="238" class="setright"> 450 &nbsp;</td>
 </tr>
 <tr>
   <td  colspan="3">หมายเหตุ : xxx</td>
   <td width="304" class="setright">ยอดรวม : xxx &nbsp;</td>
   <td width="238" class="setright">xxx &nbsp;</td>
 </tr>
  <tr>
   <td colspan="3">&nbsp;</td>
   <td width="304" class="setright">ยอดรวมสุทธิ : xxx &nbsp;</td>
   <td width="238" class="setright">xxx &nbsp;</td>
 </tr>
</table>
   </td>
</tr>
<tr>
    <td colspan="2" class="setright">สองร้อยสิบบาทถ้วน &nbsp;</td>
</tr>
</table>
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output($output, 'I');
