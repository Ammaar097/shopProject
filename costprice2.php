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
    <link rel="stylesheet" href="./src/css/costprice2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style type="text/css">
        #ChartTable {
            width: 80%;
            margin: auto;
        }
    </style>
</head>
<?php
include_once('nav.php');
include_once "./database/Product.php";
$product = new Product();
$category = new Category();
$p = $product->fetchAll();
?>

<body>
    <div class="row">
        <div class="col-1 Nbar min-vh-100"><?php include_once('bar.php'); ?></div>
        <div class="col-11">
            <div class="row main">
                <div class="col-6 d-flex justify-content-start">
                    <span style="font-size: 40pt">ราคาทุน</span>
                </div>
                <div class="col-5" style="margin: auto; text-align: end;">

                </div>
            </div>
            <div class="row main q">
                <div class="col-12 ">
                    <div>
                        <span style="font-size: 25pt">ชื่อสินค้า : </span>&nbsp;&nbsp;
                        <select name="product_id" id="product_id" style="background-color: #D4DDC6; font-size: 19pt; margin: auto;" required>
                            <option value="all" selected hidden>เลือกสินค้า</option>
                            <?php foreach ($p as $row) { ?>
                                <option value="<?= $row['product_id'] ?>"><?= $row['product_name'] ?></option>
                            <?php } ?>
                        </select>

                    </div>
                    <p>
                    <div>
                        <h4>ประเภทสินค้า :&nbsp;&nbsp;<span id="category_name" style="font-size: 25pt"></span>
                            <h4>
                    </div>
                    <p>
                    <div>
                        <h4>รุ่น :&nbsp;&nbsp;<span id="brand" style="font-size: 25pt"></span>
                            <h4>
                    </div>
                    <p>
                    <div class="title page">
                        <h4 style="display: inline;">วันที่ซื้อ :</h4>
                        &nbsp &nbsp
                        <input value="<?= isset($_GET['start']) ? $_GET['start'] : '' ?>" type="date" class="l" name="start" id="start" style=" background-color: #F8E4C8;" required>
                        &nbsp ถึง &nbsp
                        <input value="<?= isset($_GET['end']) ? $_GET['end'] : '' ?>" type="date" class="l" name="end" id="end" style=" background-color: #F8E4C8;" required>
                        &nbsp &nbsp &nbsp
                        <click type="submit" id="search" name="search" class=""><img src="./src/images/search.png" width="15"></click>
                    </div>
                </div>
                <!-- กราฟ-->
                <p>
                <p>
                <div id="ChartTable"></div>
            </div>
        </div>
    </div>
</body>
<script src="./src/js/costprice2.js"></script>
<script>
    var input = document.getElementById("start");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
    var input2 = document.getElementById("end");
    input2.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("search").click();
        }
    });
</script>

</html>