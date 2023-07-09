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
    <link rel="stylesheet" href="./src/css/sall.css" />
    <link href="./node_modules/sweetalert2/dist/sweetalert2.css" rel="stylesheet">
    </link>

</head>

<?php
include_once('./database/Sell.php');
$sell = new Sell();
include_once('nav.php');
if (isset($_GET['keyword'])) {
    $rows = $sell->search($_GET['keyword']);
} else {
    $rows = $sell->fetchAll();
}
?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-12">
                        <h1>ผู้ขาย</h1>
                    </div>
                </div>
                <div class="row col-11 d-flex justify-content-end" style="margin-left: 3rem;">
                    <form action="sall.php" method="GET">
                        <div class="col-3 d-flex justify-content-end">
                            <input type="text" name="keyword" class="btn-d" placeholder="&nbsp ชื่อผู้ขาย"></input>
                            <button type="submit" class="s">
                                <img src="./src/images/search.png" width="15">
                            </button>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a name="btadd" class="submit btn" href="addseller.php"><img src="./src/images/plus.png" width="25" class='plus'>&nbsp เพิ่มผู้ขาย</a>
                        </div>
                    </form>
                </div>
                <?php if (count($rows) > 0) { ?>
                    <table class="ma">
                        <tr>
                            <th width="20%">ชื่อผู้ขาย</th>
                            <th width="20%">เลขประจำตัวผู้เสียภาษี</th>
                            <th width="15%">นามบัตร</th>
                            <th width="5%"><img src="./src/images/edit.png" width="25"></th>
                        </tr>
                        <tbody id="sellTable">
                            <?php foreach ($rows as $e) { ?>
                                <tr style="vertical-align:top; margin-top: 2rem;">
                                    <th name="sell_name" id="sell_name"><?= $e['sell_name']; ?></th>
                                    <th name="sell_tax_id" id="sell_tax_id"><?= $e['sell_tax_id']; ?></th>
                                    <th name="seller_cardname" id="seller_cardname"><a href="<?= $e['seller_cardname']; ?>"><img src="<?= $e['seller_cardname']; ?>" width="300" height="200" /></a></th>
                                    <th>
                                        <button type="button" class="btn1" onclick="del(<?= $e['sell_id']; ?>)"><img src="./src/images/icon-delete.png" width="25"></button>
                                        <a type="button" class="btn1" href="editseller.php?id=<?= $e['sell_id']; ?>"><img src="./src/images/icon-pencil.png" width="25"></a>
                                    </th>
                                </tr> <?php } ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>';
                } ?>
            </div>
        </div>
    </form>
</body>
<script src="./node_modules/sweetalert2/dist/sweetalert2.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./src/js/sall.js"></script>

</html>