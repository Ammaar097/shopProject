<?php
include_once('service/auth.php');
isNotAdmin();
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
    <link rel="stylesheet" href="./src/css/bankslip.css"/>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


</head>
<?php
include_once('nav.php');
include_once "./database/Sales.php";
$sales = new Sales();
$rows = $sales->fetchBankSlipId($_GET['id']);
?>

<body>
<div class="row">
    <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
    <div class="col-11">
        <!-- หัวข้อหลัก -->
        <div class="row main">
            <div class="col">
                <h1>แนบสลิปธนาคาร<h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6 importfile">
                <?php foreach ($rows as $row) { ?>
                <?php if (($row['import_files']) == "") { ?>
                    แนบใบสลิปธนาคาร : &nbsp;&nbsp;
                <button type="button" onclick="setID(<?= $row['sales_list_id'] ?>)" class="white" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/cloud-upload-alt.png" width="25"></button>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col">
                            <h6><span style="color: red; ">&nbsp*&nbsp;&nbsp;</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                        </div>
                    </div>
            <?php } else if (($row['import_files']) == NULL) { ?>
                    แนบใบสลิปธนาคาร : &nbsp;&nbsp;
                <button type="button" onclick="setID(<?= $row['sales_list_id'] ?>)" class="white" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/cloud-upload-alt.png" width="25"></button>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col">
                            <h6><span style="color: red; ">&nbsp*&nbsp;&nbsp;</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                        </div>
                    </div>
            <?php } else if (($row['import_files']) != "") { ?>
                อัพโหลดใหม่อีกรอบ :
                <button type="button" class="white" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm"><img src="./src/images/cloud-upload-alt.png" width="25"></button>
                <p></p>
                    <div class="row">
                        <div class="col">
                            <h6><span style="color: red; ">&nbsp*&nbsp;&nbsp;</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                        </div>
                    </div>
                <p></p>
                    แนบใบสลิปธนาคาร : &nbsp;&nbsp;
                <a href="<?= $row['import_files'] ?>">ดู</a>
            <?php } ?>
            </div>
            <?php } ?>
        </div>
        <?php foreach ($rows as $row) { ?>
        <?php if (($row['note']) == "") { ?>
        <?php } else if (($row['note']) == NULL) { ?>
        <?php } else if (($row['note']) != "") { ?>
            <div class="row">
                <div class="col-6 detail">
                    <label for="note">หมายเหตุ :&nbsp;&nbsp;<?= $row['note'] ?></label>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
        <div class="row d-flex justify-content-end" style="text-align: center;">
        <div class="col-3" >
            <button type="button" onclick="window.location= 'salehistory.php'" class="btn-c reset">กลับไปหน้าขาย</button>
        </div>
        </div>
    </div>
</div>

<!---modal แนบสลิปธนาคาร-->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <form action="controller/Sales.php" name="form1" id="form1" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="import_files" value="<?= $_GET['id'] ?>"/>
        <input type="hidden" name="table" value="sales"/>
        <input type="hidden" name="form_action" value="update"/>
        <input type="hidden" value="<?= $_GET['id'] ?>" name="sales_list_id" id="sales_list_id"/>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">แนบสลิปธนาคาร</h4>
                    <button type="button" id="addclose" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col ">
                            แนบสลิปธนาคาร : <input type="file" name="import_files" value="<?= $rows['import_files'] ?>" />
                            <br>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <h6><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                    </div>
                    <p></p>
                    <p></p>
                    <label for="note">หมายเหตุ :&nbsp;</label>
                    <textarea id="note" name="note" cols="40" rows="4" style="vertical-align:top;" class="bb" required><?= $row['note'] ?></textarea>
                    <p></p>
                    <p></p>
                    <div class="modal-footer">
                        <button type="submit" id="addtable" class="OK">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>
</div>
</body>
<script src="./src/js/bankslip.js"></script>

</html>