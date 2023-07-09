

function del(id) {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการรายการใบสั่งซื้อใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const order = {}
            order.table = 'order'
            order.form_action = 'delete'
            order.order_id = id
            let formdata = new FormData();
            Object.keys(order).forEach(key => formdata.append(key, order[key]));
            const requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("./controller/Order.php", requestOptions)
            Swal.fire(
                {
                    title: 'ลบใบสั่งซื้อ',
                    text: 'การลบข้อมูลเสร็จสิ้น',
                    icon: 'success',
                    timer: 3000
                }
            ).then(() => {
                location.reload()
            })
        }
    })
}