$(document).ready(function () {
    $('#post').hide()
});

$('#set_n_amt').on('click', function (e) {
    $('#post').toggle();
});

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