$(document).ready(function () {
    $('#post').hide()
});

$('#set_n_amt').on('click', function (e) {
    $('#post').toggle();
});

async function loopcostprice() {
    var formdata = new FormData();
    formdata.append("product_id", $("#product_id").val());
    formdata.append("category_id", $("#category_id").val());
    formdata.append("product_name", $("#product_name").val());
    formdata.append("cost_price", $("#cost_price").val());
    formdata.append("form_action", "insert");
    formdata.append("table", "costprice");
    var requestOptions = {
        method: 'POST',
        body: formdata,
        redirect: 'follow'
    };
    await fetch("controller/CostPrice.php", requestOptions)
}

//ตรวจสอบพร้อมส่งข้อมูล
$("#form1").submit(async function (event) {
    event.preventDefault();
    let response = await fetch('controller/Product.php', {
        method: 'POST',
        body: new FormData(document.form1)
    });
    console.log(response);
    if (!response.ok) {
        console.log(response);
    } else {
        await Swal.fire({
            icon: 'success',
            text: 'บันทึกข้อมูลเสร็จสิ้น',
        })
        console.log(await response.text());
        window.location.assign("productresult.php");
    }
});