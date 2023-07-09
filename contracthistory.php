<?php
include_once('service/auth.php');
include_once('service/dateFormat.php');
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
    <link rel="stylesheet" href="./src/css/contracthistory.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>
<?php
include_once('nav.php');
include_once "./database/Contract.php";
include_once './service/datetimeDisplay.php';
include_once './service/datetimeDisplay.php';
$contract =  new Contract();
if (isset($_GET['keyword'])) {
    $rows = $contract->searchByName($_GET['keyword']);
} else {
    $rows = $contract->fetchAll();
}
?>

<body>
    <form>
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-11">
                        <h1>ประวัติสัญญาซื้อขาย</h1>
                    </div>
                </div>
                <div class="row d-flex justify-content-end" style="margin-left: 4rem;">
                    <form action="contracthistory.php" method="GET">
                        <div class="col-2">
                            <input name="keyword" type="text" id="keyword" class="btnd" placeholder="&nbsp ชื่อ-นามสกุล">
                            <button type="submit" class="s"><img src="./src/images/search.png" width="20"></button>
                        </div>
                        <div class="col-2">
                            <a type="button" href="productlist.php" class="submit btn"><img src="./src/images/arrow.png" width="35" class="arrow">กลับไปหน้าขาย</a>
                        </div>
                    </form>
                </div>
                <?php if (count($rows) > 0) { ?>
                    <table class="col-11 contracttable">
                        <tr>
                            <th width=15%>วันที่ทำสัญญา</th>
                            <th width=10%>เลขที่สัญญา</th>
                            <th width=20%>ชื่อ-นามสกุล</th>
                            <th width=15%>มูลค่าสินค้าทั้งหมด</th>
                            <th width=10%>ยอดคงเหลือ</th>
                            <th width=10%>ใบส่งของ</th>
                            <th width=10%>ไฟล์สัญญา</th>
                            <th width=5%>พิมพ์</th>
                            <th width=5%><img src="./src/images/edit.png" width="25"></th>
                        </tr>
                        <tbody id="contracttable">
                            <?php
                            foreach ($rows as $row) { ?>
                                <tr>
                                    <th><?= dateTimeDisplay($row['date_contract']) ?></th>
                                    <th><?= $row['contract_code'] ?></th>
                                    <th>
                                        <div class="r">
                                            <a name="btRepay_Click()" class="submit BTNP" href="repay.php?id=<?= $row['contract_code']; ?>"><img class='confirm'>
                                                <?= $row['customer_prefix'] ?><?= $row['customer_firstname'] ?> <?= $row['customer_lastname'] ?>
                                            </a>
                                        </div>
                                    </th>
                                    <th><?= number_format($row['baht']) ?></th>
                                    <th><?= number_format($row['outstanding']) ?></th>
                                    <th>
                                        <a type="button" class="bgs" href="./service/PDF/template/invoice.php?id=<?= $row['contract_code']; ?>"><img src="./src/images/print.png" width="25"></a>
                                    </th>
                                    <th><?php if (!isset($row['contract_attachment'])) { ?>
                                            <button type="button" onclick="setID(<?= $row['contract_code'] ?>)" class="btn btn-primary1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/cloud-upload-alt.png" width="25">
                                            </button>
                                        <?php } else { ?>
                                            <a href="<?= $row['contract_attachment'] ?>">ดู</a>
                                        <?php } ?>
                                    </th>
                                    <th><a href="./service/PDF/template/contract.php?id=<?= $row['contract_code'] ?>"><img src="./src/images/print.png" class="g" width="25"></a></th>
                                    <th>
                                        <a type="button" class="bgs" href="editcontract.php?id=<?= $row['contract_code']; ?>"><img src="./src/images/icon-pencil.png" width="25"></a>
                                    </th>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                <?php } else {
                    echo '<div class="d-flex justify-content-center"><h3 style="margin-top: 9rem; margin-bottom: 9rem;">ไม่พบข้อมูล</h3></div>';
                } ?>
            </div>
        </div>
        </div>
        </div>
    </form>

    <!---modal เพิ่มไฟล์สัญญา-->
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="addcontract_attachment" method="post" action="./controller/Contract.php" enctype="multipart/form-data">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มไฟล์สัญญา</h5>
                        <button type="button" id="addclose" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="table" value="contract">
                            <input type="hidden" name="form_action" value="upload">
                            <input type="hidden" name="contract_code" id='upload_contract_code'>
                            <div class="col ">
                                เพิ่มไฟล์สัญญา : <input type="file" class="tt" name="contract_attachment" required>
                                <div class="k">*</div>
                                <br>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" id="addtable" class="btn btn-primary2">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./src/js/contracthistory.js"></script>
<script>
    window.onload = () => document.querySelector('.btn-close > span').remove()
</script>

</html>