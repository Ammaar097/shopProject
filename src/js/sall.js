function del(id) {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการลบผู้ขายใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const sell = await (await fetch("./controller/GetSell.php?id=" + id)).json()
            sell.table = 'sell'
            sell.form_action = 'delete'
            let formdata = new FormData();
            Object.keys(sell).forEach(key => formdata.append(key, sell[key]));
            const requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("./controller/Sell.php?id=", requestOptions)
            Swal.fire(
                {
                    title: 'ลบผู้ขาย',
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