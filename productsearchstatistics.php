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
    <link rel="stylesheet" href="./src/css/productsearchstatistics.css" />

</head>
<?php
include_once('nav.php');
include_once "./database/Search_Category.php";
$category = new Search_Category();
$rows = $category->fetchAll();
$data = array();
foreach ($rows as $row) {
    if (!isset($data[$row['category_id']])) {
        $data[$row['category_id']]['count'] = 1;
        $data[$row['category_id']]['name'] = $row['category_name'];
    } else {
        $data[$row['category_id']]['count']++;
    }
}
$data = array_values($data);
// bubble sort
$r = -1;
while ($r != 0) {
    $r = 0;
    for ($i = 0; $i < count($data); $i++) {
        if ($i + 1 < count($data)) {
            $low = $data[$i];
            $up = $data[$i + 1];
            if ($low['count'] < $up['count']) {
                $data[$i + 1] = $low;
                $data[$i] = $up;
                $r++;
            }
        }
    }
}

?>

<body>
    <form method="post" action="productsearchstatistics.php" id="form1" name="form1">
        <div class="row">
            <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
            <div class="col-11">
                <div class="row main">
                    <div class="col-10">
                        <h1>สถิติการค้นหาโดยประเภทสินค้า</h1>
                    </div>
                </div>
                <div class="row left">
                    <div class="col-1">
                        <button type="button" class="buttom re" onclick="Reset()">รีเซต</button>
                    </div>
                </div>
                <?php if (count($rows) > 0) { ?>
                    <table class="table col-10" style="margin-bottom: 4rem;">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ประเภทสินค้า</th>
                                <th>จำนวนครั้งค้นหา</th>
                            </tr>
                        </thead>
                        <tbody id="categorytable">
                            <?php $i = 1;
                            foreach ($data as $row) { ?>
                                <tr>
                                    <th><?= $i ?></th>
                                    <th><?= $row['name'] ?></th>
                                    <th><?= number_format($row['count']) ?></th>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <h3 style="text-align: center;">ไม่มีรายการ</h3>
                <?php } ?>
            </div>
        </div>
    </form>
</body>
<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="./src/js/productsearchstatistics.js"></script>

</html>