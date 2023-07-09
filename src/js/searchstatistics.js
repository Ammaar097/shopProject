/*function Reset(){
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการรีเซ็ทใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            fetch("./controller/ResetKeyword.php").then(()=>{
                location.reload()
            })
        }
    })
}*/

function Reset() {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการรีเซ็ทใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            await fetch('ResetKeyword.php', {
                method: 'POST',
                body: new FormData(form1),
            })
            Swal.fire(
                {
                    title: 'รีเซ็ท',
                    text: 'รีเซ็ทข้อมูลเสร็จสิ้น',
                    icon: 'success',
                    timer: 3000
                }
            ).then(async (result) => {
                if (result.isConfirmed) {
                    fetch("./controller/ResetKeyword.php").then(() => {
                        location.reload()
                    })
                }
            })
        }
    })
}
