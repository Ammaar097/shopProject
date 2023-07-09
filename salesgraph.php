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
    <link rel="stylesheet" href="./src/css/salesgraph.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style type="text/css">
        #ChartTable {
            width: 70%;
            margin: auto;
        }
    </style>
</head>
<?php include_once('nav.php');
include_once "./database/Category.php";
$category =  new Category();
$rows = $category->fetchAll();
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <h1>การขาย</h1>
            </div>
            <div class="row">
                <div class="col">
                    <h5 class="tt">สรุปยอดขาย</h5>
                    <div class="th"></div>
                </div>
            </div>
            <div class="row q">
                <div class="col-3">
                    ประเภทสินค้า &nbsp;:&nbsp;&nbsp;
                    <select name="category_id" id="category_id" class="sizeselect" style="background-color: #D4DDC6;">
                        <option value="all">ทั้งหมด</option>
                        <?php foreach ($rows as $row) { ?>
                            <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-3" style="margin-left: -2rem;">
                    วันที่ขาย &nbsp;:&nbsp;&nbsp;
                    <input type="date" id="date" name="date" value="<?= date('Y-m-d') ?>" style="height: 102%; margin-top: auto;" class="sizeselect">
                </div>
                <div class="col-1 search" style="margin-left: -3rem;">
                    <select name="limit" id="limit" class="sizeselect" style="background-color: #D4DDC6;">
                        <option value="5">5 อันดับแรก</option>
                        <option value="10">10 อันดับแรก</option>
                    </select>
                </div>
                <div class="col-1 search" style="margin-left: 3rem;">
                    <click type="submit" id="search" class="search"><img src="./src/images/search.png" width="35"></click>
                </div>
            </div>
            <p></p>
            <h3 class="tt">ยอดขายสินค้า</h3>
            <div id="ChartTable"></div>
        </div>
    </div>
</body>
<script src="./src/js/salesgraph.js"></script>
<script>
    var input1 = document.getElementById("date");
    input1.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
    var input2 = document.getElementById("category_id");
    input2.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
    var input3 = document.getElementById("limit");
    input3.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
</script>

</html>