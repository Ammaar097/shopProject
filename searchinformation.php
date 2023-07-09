<?php
include_once('service/auth.php');
isLaber();
function getFullRole($role)
{
    if ($role == "E") {
        return 'พนักงาน';
    }
    if ($role == "L") {
        return 'เจ้าของร้าน';
    }
    if ($role == "A") {
        return 'ผู้ดูแลระบบ';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/css/searchinformation.css" />

</head>
<?php
include_once('nav.php');
include_once('./database/Category.php');
$category = new Category();
$rows = $category->fetchAll();
?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <h1>ค้นหาข้อมูลการซื้อสินค้า </h1>
                    <div class="col-11" style="text-align: center;">
                        เลขที่ใบเสร็จ :&nbsp &nbsp
                        <input type="text" class="btnd" id="keyword" name="keyword" placeholder="&nbsp;&nbsp; ค้นหาเลขที่ใบเสร็จ">
                        <click type="button" id="search" name="search" class="s"><img src="./src/images/search.png" width="13"></click>
                    </div>
                    <h3 class="notification" id="no-let">กรอกเลขที่ใบเสร็จเพื่อค้นหา</h3>
                    <table class="col-11 tablesearch" id="tb-let">
                        <thead>
                            <tr class="h">
                                <th width="7.5%">ลำดับ</th>
                                <th width="20%">รูปภาพ</th>
                                <th width="25%">สินค้า</th>
                                <th width="12.5%">ราคาต่อชิ้น</th>
                                <th width="10%">จำนวน</th>
                                <th width="12.5%">ราคารวม</th>
                                <th width="12.5%">สถานะเปลี่ยนสินค้า</th>
                            </tr>
                        </thead>
                        <tbody id="searchTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</body>
<script src="./src/js/searchinformation.js"></script>
<script>
    var input = document.getElementById("keyword");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
</script>

</html>