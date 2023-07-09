function Submit() {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการบันทึกใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await fetch('changeproduct.php', {
                method: 'POST',
                body: new FormData(form1),
            })
            Swal.fire(
                {
                    title: 'บันทึก',
                    text: 'บันทึกข้อมูลเสร็จสิ้น',
                    icon: 'success',
                    timer: 3000
                }
            ).then(() => {
                location.reload()
            })
        }
    })
}
