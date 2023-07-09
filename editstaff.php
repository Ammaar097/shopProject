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
    <link rel="stylesheet" href="./src/css/editstaff.css" />
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>


</head>
<?php
include_once('nav.php');
include_once('database/Employee.php');
include_once('database/EmployeeBank.php');
include_once('./service/datetimeDisplay.php');
$employee = new Employee();
$e = $employee->fetchById($_GET['id']);
$employeeBank = new Employeebank();
$banks = $employeeBank->fetchByEmployeeId($_GET['id']);
$json = '';
for ($i = 0; $i < count($banks); $i++) {
    $b = $banks[$i];
    $json .= "{
        bank: \"" . $b['bank_name'] . "\",
        number: \"" . $b['bank_number'] . "\",
        name: \"" . $b['bank_account'] . "\",
        id:\"" . $b['bank_id'] . "\"
    }";
    if ($i + 1 != count($banks)) {
        $json .= ",";
    }
}

?>

<body>
    <form action="" name="form1" id="form1">
        <input type="hidden" name="employee_card_id_copy" value="<?= $e['employee_card_id_copy']; ?>" />
        <input type="hidden" name="employee_address_copy" value="<?= $e['employee_address_copy']; ?>" />
        <input type="hidden" name="bank" value="" id="bank" />
        <input type="hidden" name="table" value="employee" />
        <input type="hidden" name="form_action" value="update" />
        <input type="hidden" value="<?= $_GET['id'] ?>" name="employee_id" id="employee_id" />
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col">
                        <h1>แก้ไขพนักงาน</h1>
                    </div>
                </div>
                <table class="mai">
                    <tr>
                        <th class="mm">กำหนดรูปแบบพนักงาน</th>
                    </tr>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col-4 leftmodel">
                                    <label for="employee_model">รูปแบบพนักงาน :</label><b class="bb"><?= $e['employee_model']; ?></b>
                                </div>
                                <div class="col-4 leftstartwork">
                                    <label for="employee_startwork_dt">วันที่เข้าทำงาน :</label><b class="bb"><?= dateTimeDisplay($e['employee_startwork_dt']); ?></b>
                                </div>
                            </div>
                            <br>
                        </th>
                    </tr>
                    <tr>
                        <th class="mm">ข้อมูลพนักงาน</th>
                    </tr>
                    <tr>
                        <th>
                            <div class="row-4 ma">
                                <label for="employee_prefix">คำนำหน้าชื่อ : </label><b class="bb"><?= $e['employee_prefix']; ?></b>
                            </div>
                            <div class="row">
                                <div class="col leftname">
                                    <label for="employee_firstname">ชื่อ :</label>
                                    <input name="employee_firstname" type="text" value="<?= $e['employee_firstname']; ?>" id="employee_firstname" class="bb" required />
                                    <div class="c">*</div>
                                </div>
                                <div class="col leftlastname">
                                    <label for="employee_lastname">นามสกุล :</label>
                                    <input name="employee_lastname" type="text" value="<?= $e['employee_lastname']; ?>" id="employee_lastname" class="bb" class="bb" required />
                                    <div class="d">*</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col leftidcardnumber">
                                    <label for="employee_card_id">เลขบัตรประชาชน :</label><b class="bb"><?= ($e['employee_card_id']); ?></b>
                                </div>
                                <div class="col leftbirthday">
                                    <label for="employee_birthday">วันเกิด :</label><b class="bb"><?= dateTimeDisplay($e['employee_birthday']); ?></b>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th class="mm">ข้อมูลผู้ติดต่อ</th>
                    </tr>
                    <tr>
                        <th>
                            <div class="row">
                                <div class="col lefttelephone">
                                    <label for="employee_telephone">โทรศัพท์ :</label>
                                    <input name="employee_telephone" type="text" value="<?= $e['employee_telephone']; ?>" id=employee_telephone onkeyup="autoTab2(this)" class="bb" required />
                                    <div class="g">*</div>
                                </div>
                                <div class="col leftemail">
                                    <label for="employee_email">อีเมล :</label>
                                    <input name="employee_email" type="email" value="<?= $e['employee_email']; ?>" id="employee_email" onblur='check_email(this)' class="bb" required />
                                    <div class="h">*</div>
                                </div>
                            </div>
                            <div class="col leftaddress">
                                ที่อยู่ :<span style="color: red; ">&nbsp*</span>
                                <textarea name="employee_address" id="employee_address" cols="22" rows="4" class="cc" style="vertical-align:top;" type="text" required><?= $e['employee_address']; ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col leftn">สำเนาบัตรประชาชน :
                                    <input type="file" accept="image/*" id="employee_card_id_copy" name="employee_card_id_copy" class="bb">
                                </div>
                                <div class="col leftnb">สำเนาทะเบียนบ้าน :
                                    <input type="file" accept="image/*" id="employee_address_copy" name="employee_address_copy" class="bb">
                                </div>
                                <div class="row leftpng">
                                    <h6><span style="color: red; ">&nbsp*</span>ประเภทไฟล์ที่ยอมรับ: .jpg, .jpeg, .png ขนาดไฟล์ไม่เกิน 8 MB</h6>
                                </div>
                    <tr>
                        <th class="mm">บัญชีรับเงิน</th>
                    </tr>
                    <tr>
                        <th>
                            <div class="col d-flex justify-content-end">
                                <button type="button" id="addmodel_btn" class="btn btn-primary1" data-bs-toggle="modal" data-bs-target=".bd-example-modal-sm">เพิ่มบัญชีใหม่</button>
                            </div>
            </div>
            <table class="wh m">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ธนาคาร</th>
                        <th>เลขบัญชี</th>
                        <th>ชื่อบัญชี</th>
                        <th><img src="./src/images/edit.png" width="25"></th>
                    </tr>
                </thead>
                <tbody id="banktable">
                    <?php $i = 0;
                    foreach ($banks as $b) { ?>
                        <tr id="rr<?= $i ?>">
                            <th class="index-table-bank"><?= $i + 1 ?></th>
                            <th><?= $b['bank_name'] ?></th>
                            <th><?= $b['bank_number'] ?></th>
                            <th><?= $b['bank_account'] ?></th>
                            <th>
                                <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target="#exampleModal"><img src="./src/images/icon-delete.png" width="25" onclick="saveIndexDel(<?= $i ?>)"></button>
                                <button type="button" class="bgs" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl1"><img src="./src/images/icon-pencil.png" width="25" onclick="saveIndexEdit(<?= $i ?>)"></button>
                            </th>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table><br>
            </th>
            </tr>
            </table>
            <div class="row btn-g">
                <div class="col-2">
                    <button type="reset" class="btn-c reset" onclick="javascript:window.location='employee.php';">ยกเลิก</button>
                </div>
                <div class="col-2">
                    <input type="submit" class="btn-c submit" value="บันทึก" />
                </div>
            </div>
        </div>
    </form>

    <!---modal เพิ่มบัญชีใหม่-->
    <div class="modal fade bd-example-modal-sm tabindex=" -1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="addbankaccount" method="post" id="addbankaccount">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มบัญชีใหม่</h5>
                        <button type="button" id="addclose" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label for="bank_name">ธนาคาร : </label>
                            <select name="bank_name" id="bank_name" style="background-color: #D4DDC6;" required>
                                <option value="" selected hidden>เลือกธนาคาร</option>
                                <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                            </select>
                        </div><br>
                        <div class="row">
                            เลขบัญชี : <input type="text" id="bank_number" name="bank_number" required></input>
                        </div><br>
                        <div class="row">
                            ชื่อบัญชี : <input type="text" id="bank_account" name="bank_account" required></input>
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

    <!-- ลบ -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title2" id="exampleModalLabel">ลบบัญชีรับเงิน</h5>
                    <button type="button" class="btn-close" id="closedelrow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>ยืนยันที่จะลบ</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="delrow()" class="btn btn-primary2">ตกลง</button>
                </div>
            </div>
        </div>
    </div>

    <!---modal แก้ไขบัญชีรับเงิน-->
    <div class="modal fade bd-example-modal-xl1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <form name="editbankaccount" id="editbankaccount" method="post" action="">
            <div class="modal-dialog modal-xl1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขบัญชีรับเงิน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" id="editclose" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col leftbank ">
                                <label for="editbank_name">ธนาคาร : </label>
                                <select name="editbank_name" id="editbank_name" style="background-color: #D4DDC6;">
                                    <option value="" selected hidden>เลือกธนาคาร</option>
                                    <option value="ธนาคารกรุงไทย">ธนาคารกรุงไทย</option>
                                    <option value="ธนาคารไทยพาณิชย์">ธนาคารไทยพาณิชย์</option>
                                    <option value="ธนาคารกสิกรไทย">ธนาคารกสิกรไทย</option>
                                    <option value="ธนาคารกรุงเทพ">ธนาคารกรุงเทพ</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col leftanb">
                                เลขบัญชี : <input type="text" id="editbank_number" name="editbank_number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col leftan">
                                ชื่อบัญชี : <input type="text" id="editbank_account" name="editbank_account">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary2">ตกลง</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        localStorage.clear()
        localStorage.setItem("tableBank", JSON.stringify({
            data: [<?php echo $json; ?>]
        }))
    });
</script>
<script src="./node_modules/jquery/dist/jquery.min.js"></script>
<script src="./src/js/editstaff.js"></script>

</html>