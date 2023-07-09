<!DOCTYPE html>
<html>
<?php include_once('./database/Category.php');
$category = new Category();
$c = $category->fetchAll();
date_default_timezone_set("Asia/Bangkok");
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/css/bar2.css" />
</head>

<body>
    <div class="nav flex-column bar">
        <ul id="myMenu">
            <li><a style="font-size: 18px;" href="./customer.php">สินค้าทั้งหมด</a></li>
            <?php
            foreach ($c as $list) { ?>
                <li><a style="font-size: 18px;" href="./customer.php?category=<?= $list['category_id'] ?>"><?= $list['category_name'] ?></a></li>
            <?php } ?>
            <br>
            <br>
            <h6 class="datetime">วันที่&nbsp;&nbsp;<?php echo date("d-m-Y"); ?></h6>
            <h6 class="datetime">เวลา &nbsp;<?php echo date("H:i"); ?></h6>
        </ul>
        <br>
    </div>
</body>

</html>