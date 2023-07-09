function del(id) {
    Swal.fire({
        title: 'คำเตือน',
        text: "คุณต้องการลบพนักงานใช่หรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const employee = await (await fetch("./controller/GetEmployee.php?id=" + id)).json()
            employee.table = 'employee'
            employee.form_action = 'delete'
            let formdata = new FormData();
            Object.keys(employee).forEach(key => formdata.append(key, employee[key]));
            const requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };
            await fetch("./controller/Employee.php?id=", requestOptions)
            Swal.fire(
                {
                    title: 'ลบพนักงาน',
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


async function setStatus(id) {
    const status = $("#S" + id).is(':checked');
    console.log(await (await fetch(`./controller/SetEmployeeStatus.php?status=${status}&id=${id}`)))
}